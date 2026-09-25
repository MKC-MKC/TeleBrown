<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Haikiri\TeleBrown\TeleBrownServer;
use PHPUnit\Framework\TestCase;

final class TeleBrownServerChatSettingsMethodsTest extends TestCase
{

	public function testChatPhotoUploadsLocalFile(): void
	{
		$path = tempnam(sys_get_temp_dir(), "telebrown-chat-photo-");
		self::assertNotFalse($path);
		file_put_contents($path, "chat-photo-content");

		try {
			$history = [];
			$server = $this->createServer($history, true);

			self::assertTrue($server->setChatPhoto(-1001234567890, $path));

			$request = $history[0]["request"];
			$body = (string)$request->getBody();
			self::assertSame("/bot123:TOKEN/setChatPhoto", $request->getUri()->getPath());
			self::assertStringStartsWith("multipart/form-data; boundary=", $request->getHeaderLine("Content-Type"));
			self::assertStringContainsString('name="chat_id"', $body);
			self::assertStringContainsString("-1001234567890", $body);
			self::assertStringContainsString('name="photo"; filename="' . basename($path) . '"', $body);
			self::assertStringContainsString("chat-photo-content", $body);
		} finally {
			unlink($path);
		}
	}

	private function createServer(array &$history, bool $result): TeleBrownServer
	{
		$mock = new MockHandler([
			new GuzzleResponse(200, [], json_encode(["ok" => true, "result" => $result], JSON_THROW_ON_ERROR)),
		]);
		$handler = HandlerStack::create($mock);
		$handler->push(Middleware::history($history));

		return new class("https://api.telegram.org", "123:TOKEN", $handler) extends TeleBrownServer {
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
