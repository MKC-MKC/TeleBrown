<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Haikiri\TeleBrown\Objects\Message;
use Haikiri\TeleBrown\TeleBrownServer;
use PHPUnit\Framework\TestCase;

final class TeleBrownServerEditMessageTest extends TestCase
{

	public function testEditInlineMessageReturnsTrueAndOmitsChatAddress(): void
	{
		$history = [];
		$server = $this->createServer($history, true);

		$result = $server->editMessageText(null, null, "Updated", inlineMessageId: "INLINE_MESSAGE_ID");

		self::assertTrue($result);
		self::assertSame(
			"https://api.telegram.org/bot123:TOKEN/editMessageText",
			(string)$history[0]["request"]->getUri(),
		);
		self::assertSame(
			["text" => "Updated", "inline_message_id" => "INLINE_MESSAGE_ID"],
			json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR),
		);
	}

	public function testEditChatMessageReturnsMessageAndPreservesPositionalArguments(): void
	{
		$history = [];
		$message = [
			"message_id" => 42,
			"date" => 1720000000,
			"chat" => ["id" => -1001234567890, "type" => "supergroup"],
			"text" => "Updated",
		];
		$server = $this->createServer($history, $message);

		$result = $server->editMessageText(-1001234567890, 42, "Updated");

		self::assertInstanceOf(Message::class, $result);
		self::assertSame($message, $result->getAsArray());
		self::assertSame(
			["chat_id" => -1001234567890, "message_id" => 42, "text" => "Updated"],
			json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR),
		);
	}

	private function createServer(array &$history, array|bool $result): TeleBrownServer
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
