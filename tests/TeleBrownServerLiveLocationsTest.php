<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects\InlineKeyboardMarkup;
use Haikiri\TeleBrown\Objects\Message;
use Haikiri\TeleBrown\TeleBrownServer;
use PHPUnit\Framework\TestCase;

final class TeleBrownServerLiveLocationsTest extends TestCase
{

	public function testEditInlineLocationPreservesZeroCoordinatesAndAccuracy(): void
	{
		$history = [];
		$server = $this->createServer($history, true);

		self::assertTrue($server->editMessageLiveLocation(0, 0, inlineMessageId: "INLINE", horizontalAccuracy: 0));
		self::assertSame("/bot123:TOKEN/editMessageLiveLocation", $history[0]["request"]->getUri()->getPath());
		self::assertSame(
			["latitude" => 0, "longitude" => 0, "inline_message_id" => "INLINE", "horizontal_accuracy" => 0],
			json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR),
		);
	}

	public function testEditChatLocationReturnsMessageAndPassesOptionalParameters(): void
	{
		$history = [];
		$message = ["message_id" => 42, "location" => ["latitude" => 55.75, "longitude" => 37.61]];
		$server = $this->createServer($history, $message);
		$markup = new InlineKeyboardMarkup(["inline_keyboard" => []]);

		$result = $server->editMessageLiveLocation(
			55.75, 37.61, chatId: "@channel", messageId: 42,
			businessConnectionId: "BUSINESS", livePeriod: 0x7FFFFFFF,
			horizontalAccuracy: 12.5, heading: 360, proximityAlertRadius: 100000, replyMarkup: $markup,
		);

		self::assertInstanceOf(Message::class, $result);
		self::assertSame($message, $result->getAsArray());
		self::assertSame(
			[
				"latitude" => 55.75, "longitude" => 37.61, "chat_id" => "@channel", "message_id" => 42,
				"business_connection_id" => "BUSINESS", "live_period" => 0x7FFFFFFF,
				"horizontal_accuracy" => 12.5, "heading" => 360, "proximity_alert_radius" => 100000,
				"reply_markup" => ["inline_keyboard" => []],
			],
			json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR),
		);
	}

	public function testEditExpiredLiveLocationPropagatesTelegramError(): void
	{
		$history = [];
		$server = $this->createServer($history, true, "Bad Request: message can't be edited");

		$this->expectException(TelegramMainException::class);
		$this->expectExceptionCode(400);
		$this->expectExceptionMessage("Bad Request: message can't be edited");

		$server->editMessageLiveLocation(55.75, 37.61, inlineMessageId: "INLINE");
	}

	public function testStopInlineLocationReturnsTrueAndOmitsChatAddress(): void
	{
		$history = [];
		$server = $this->createServer($history, true);

		self::assertTrue($server->stopMessageLiveLocation(inlineMessageId: "INLINE"));
		self::assertSame("/bot123:TOKEN/stopMessageLiveLocation", $history[0]["request"]->getUri()->getPath());
		self::assertSame(
			["inline_message_id" => "INLINE"],
			json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR),
		);
	}

	public function testStopChatLocationReturnsMessageAndUpdatesKeyboard(): void
	{
		$history = [];
		$message = ["message_id" => 42, "location" => ["latitude" => 55.75, "longitude" => 37.61]];
		$server = $this->createServer($history, $message);

		$result = $server->stopMessageLiveLocation(
			-1001234567890, 42, businessConnectionId: "BUSINESS",
			replyMarkup: new InlineKeyboardMarkup(["inline_keyboard" => []]),
		);

		self::assertInstanceOf(Message::class, $result);
		self::assertSame($message, $result->getAsArray());
		self::assertSame(
			[
				"chat_id" => -1001234567890, "message_id" => 42, "business_connection_id" => "BUSINESS",
				"reply_markup" => ["inline_keyboard" => []],
			],
			json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR),
		);
	}

	public function testStopMissingLiveLocationPropagatesTelegramError(): void
	{
		$history = [];
		$server = $this->createServer($history, true, "Bad Request: message to edit not found");

		$this->expectException(TelegramMainException::class);
		$this->expectExceptionCode(400);
		$this->expectExceptionMessage("Bad Request: message to edit not found");

		$server->stopMessageLiveLocation(inlineMessageId: "INLINE");
	}

	private function createServer(array &$history, array|bool $result, string|null $error = null): TeleBrownServer
	{
		$mock = new MockHandler([
			new GuzzleResponse($error === null ? 200 : 400, [], json_encode(
				$error === null ? ["ok" => true, "result" => $result] : ["ok" => false, "error_code" => 400, "description" => $error],
				JSON_THROW_ON_ERROR,
			)),
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
