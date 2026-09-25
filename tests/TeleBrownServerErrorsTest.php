<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\TeleBrownServer;
use PHPUnit\Framework\TestCase;

final class TeleBrownServerErrorsTest extends TestCase
{

	public function testTelegramHttpErrorsPreserveDescriptionAndCodeWithoutToken(): void
	{
		$errors = [
			[400, "Bad Request: message to delete not found"],
			[403, "Forbidden: bot was blocked by the user"],
			[429, "Too Many Requests: retry after 30"],
		];
		$server = $this->createServer(array_map(
			static fn(array $error): GuzzleResponse => new GuzzleResponse(
				$error[0], [], json_encode([
					"ok" => false, "error_code" => $error[0], "description" => $error[1],
				], JSON_THROW_ON_ERROR),
			),
			$errors,
		));

		foreach ($errors as [$code, $description]) {
			try {
				$server->deleteMessage(17, 42);
				self::fail("Expected a Telegram API exception");
			} catch (TelegramMainException $e) {
				self::assertSame($code, $e->getCode());
				self::assertSame($description, $e->getMessage());
				self::assertStringNotContainsString("123:SECRET_TOKEN", (string)$e);
				self::assertStringNotContainsString("telegram.example.test", (string)$e);
				self::assertNull($e->getPrevious());
			}
		}
	}

	public function testConnectionFailureDoesNotRetainSecretUrlInExceptionChain(): void
	{
		$secretUrl = "https://telegram.example.test/bot123:SECRET_TOKEN/sendMessage";
		$server = $this->createServer([
			new ConnectException("Connection failed for " . $secretUrl, new Request("POST", $secretUrl)),
		]);

		try {
			$server->sendMessage(17, "Hello");
			self::fail("Expected a transport exception");
		} catch (TelegramMainException $e) {
			self::assertSame("Unable to send Telegram API request", $e->getMessage());
			self::assertStringNotContainsString("123:SECRET_TOKEN", (string)$e);
			self::assertStringNotContainsString("telegram.example.test", (string)$e);
			self::assertNull($e->getPrevious());
		}
	}

	private function createServer(array $responses): TeleBrownServer
	{
		$handler = HandlerStack::create(new MockHandler($responses));

		return new class("https://telegram.example.test", "123:SECRET_TOKEN", $handler) extends TeleBrownServer {
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
