<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\TeleBrownServer;
use PHPUnit\Framework\TestCase;

final class TeleBrownServerFileTest extends TestCase
{

	public function testMultipartRequestFiltersNullAndAddsBoundary(): void
	{
		$history = [];
		$source = tempnam(sys_get_temp_dir(), "telebrown-source-");
		self::assertNotFalse($source);
		file_put_contents($source, "content");

		try {
			$server = $this->createServer(
				history: $history,
				responses: [new GuzzleResponse(200, [], '{"ok":true,"result":[]}')],
			);

			$server->sendRequest(
				method: "upload",
				params: [
					"document" => $source,
					"caption" => null,
					"protect_content" => false,
				],
				headers: ["Content-Type" => "multipart/form-data"],
			);

			$request = $history[0]["request"];
			$body = (string)$request->getBody();

			self::assertMatchesRegularExpression('/^multipart\/form-data; boundary=.+$/', $request->getHeaderLine("Content-Type"));
			self::assertStringContainsString('name="document"', $body);
			self::assertStringContainsString('name="protect_content"', $body);
			self::assertStringNotContainsString('name="caption"', $body);
		} finally {
			if (is_file($source)) unlink($source);
		}
	}

	public function testDownloadFileUsesCustomBaseUrlAndOverwritesOnlyWhenRequested(): void
	{
		$history = [];
		$destination = sys_get_temp_dir() . "/telebrown-destination-" . bin2hex(random_bytes(8));

		try {
			$server = $this->createServer(
				history: $history,
				responses: [
					new GuzzleResponse(200, [], '{"ok":true,"result":{"file_id":"file-id","file_unique_id":"unique-id","file_size":7,"file_path":"voice notes/answer #1.ogg"}}'),
					new GuzzleResponse(200, [], "content"),
					new GuzzleResponse(200, [], '{"ok":true,"result":{"file_id":"file-id","file_unique_id":"unique-id","file_size":11,"file_path":"voice notes/answer #1.ogg"}}'),
					new GuzzleResponse(200, [], "replacement"),
				],
				url: "https://telegram.example.test/file/bot999:OLD_TOKEN",
				token: "123:SECRET_TOKEN",
			);

			$file = $server->downloadFile("file-id", $destination);

			self::assertSame("file-id", $file->getFileId());
			self::assertSame("voice notes/answer #1.ogg", $file->getFilePath());
			self::assertSame("content", file_get_contents($destination));
			self::assertSame("https://telegram.example.test/bot123:SECRET_TOKEN/getFile", (string)$history[0]["request"]->getUri());
			self::assertSame("https://telegram.example.test/file/bot123:SECRET_TOKEN/voice%20notes/answer%20%231.ogg", (string)$history[1]["request"]->getUri());
			self::assertSame('{"file_id":"file-id"}', (string)$history[0]["request"]->getBody());

			$server->downloadFile("file-id", $destination, true);

			self::assertSame("replacement", file_get_contents($destination));
		} finally {
			if (is_file($destination)) unlink($destination);
		}
	}

	public function testDownloadFileDoesNotRequestNetworkForExistingDestination(): void
	{
		$history = [];
		$destination = sys_get_temp_dir() . "/telebrown-existing-" . bin2hex(random_bytes(8));
		file_put_contents($destination, "existing content");
		$server = $this->createServer(history: $history, responses: []);

		try {
			$server->downloadFile("file-id", $destination);
			self::fail("Expected an exception for an existing destination");
		} catch (TelegramMainException $e) {
			self::assertSame("Destination file already exists", $e->getMessage());
			self::assertSame([], $history);
			self::assertSame("existing content", file_get_contents($destination));
		} finally {
			if (is_file($destination)) unlink($destination);
		}
	}

	public function testDownloadFileDoesNotExposeTokenOnTransportFailure(): void
	{
		$history = [];
		$destination = sys_get_temp_dir() . "/telebrown-failed-" . bin2hex(random_bytes(8));
		$secretUrl = "https://telegram.example.test/file/bot123:SECRET_TOKEN/file.txt";
		$server = $this->createServer(
			history: $history,
			responses: [
				new GuzzleResponse(200, [], '{"ok":true,"result":{"file_id":"file-id","file_unique_id":"unique-id","file_path":"file.txt"}}'),
				new RequestException("Request failed for " . $secretUrl, new Request("GET", $secretUrl)),
			],
			token: "123:SECRET_TOKEN",
		);

		try {
			$server->downloadFile("file-id", $destination);
			self::fail("Expected a transport exception");
		} catch (TelegramMainException $e) {
			self::assertSame("Unable to download Telegram file", $e->getMessage());
			self::assertStringNotContainsString("SECRET_TOKEN", (string)$e);
			self::assertStringNotContainsString("telegram.example.test", (string)$e);
			self::assertNull($e->getPrevious());
			self::assertFileDoesNotExist($destination);
		}
	}

	private function createServer(
		array &$history,
		array $responses,
		string $url = "https://api.telegram.org",
		string $token = "123:TOKEN",
	): TeleBrownServer
	{
		$mock = new MockHandler($responses);
		$handler = HandlerStack::create($mock);
		$handler->push(Middleware::history($history));

		return new class($url, $token, $handler) extends TeleBrownServer {
			public function __construct(string $url, string $token, private readonly HandlerStack $handler)
			{
				parent::__construct($url, $token);
			}

			protected function createClient(array $options): Client
			{
				$options["handler"] = $this->handler;

				return parent::createClient($options);
			}
		};
	}

}
