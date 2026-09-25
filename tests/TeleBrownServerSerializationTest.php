<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Haikiri\TeleBrown\Objects\InlineKeyboardButton;
use Haikiri\TeleBrown\Objects\InlineKeyboardMarkup;
use Haikiri\TeleBrown\Objects\MessageEntity;
use Haikiri\TeleBrown\Objects\ReplyParameters;
use Haikiri\TeleBrown\TeleBrownServer;
use PHPUnit\Framework\TestCase;

final class TeleBrownServerSerializationTest extends TestCase
{

	public function testGetAsArrayConvertsNestedModelsAndPreservesValues(): void
	{
		$button = new InlineKeyboardButton(["text" => "0", "callback_data" => ""]);
		$markup = InlineKeyboardMarkup::buttons([$button]);

		self::assertSame([
			"inline_keyboard" => [[["text" => "0", "callback_data" => ""]]],
		], $markup->getAsArray());
		self::assertSame([
			"message_id" => 0,
			"allow_sending_without_reply" => false,
			"quote_entities" => [],
			"chat_id" => null,
		], (new ReplyParameters([
			"message_id" => 0,
			"allow_sending_without_reply" => false,
			"quote_entities" => [],
			"chat_id" => null,
		]))->getAsArray());
		self::assertNull((new ReplyParameters(null))->getAsArray());
	}

	public function testSendMessageSerializesNestedModels(): void
	{
		$history = [];
		$server = $this->createServer($history);
		$entity = new MessageEntity(["type" => "bold", "offset" => 0, "length" => 5]);
		$button = new InlineKeyboardButton(["text" => "OK", "callback_data" => "ok"]);

		$server->sendMessage(
			chatId: 17,
			text: "Hello",
			entities: [$entity],
			replyParameters: new ReplyParameters([
				"message_id" => 42, "quote" => "Hello", "quote_entities" => [$entity],
				"allow_sending_without_reply" => false,
			]),
			replyMarkup: InlineKeyboardMarkup::buttons([$button]),
		);

		self::assertSame([
			"chat_id" => 17,
			"text" => "Hello",
			"entities" => [["type" => "bold", "offset" => 0, "length" => 5]],
			"reply_parameters" => [
				"message_id" => 42, "quote" => "Hello",
				"quote_entities" => [["type" => "bold", "offset" => 0, "length" => 5]],
				"allow_sending_without_reply" => false,
			],
			"reply_markup" => ["inline_keyboard" => [[["text" => "OK", "callback_data" => "ok"]]]],
		], json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));
	}

	public function testDirectRequestDoesNotDoubleEncodeModels(): void
	{
		$history = [];
		$server = $this->createServer($history);

		$server->sendRequest("sendMessage", [
			"chat_id" => 17,
			"text" => "Hello",
			"reply_markup" => InlineKeyboardMarkup::buttons([
				new InlineKeyboardButton(["text" => "OK", "callback_data" => "ok"]),
			]),
		]);

		self::assertSame([
			"chat_id" => 17,
			"text" => "Hello",
			"reply_markup" => ["inline_keyboard" => [[["text" => "OK", "callback_data" => "ok"]]]],
		], json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));
	}

	public function testMediaRequestSerializesCaptionEntitiesAndButtons(): void
	{
		$history = [];
		$server = $this->createServer($history);

		$server->sendPhoto(
			chatId: 17,
			photo: "telegram-file-id",
			caption: "Hello",
			captionEntities: [new MessageEntity(["type" => "bold", "offset" => 0, "length" => 5])],
			replyMarkup: InlineKeyboardMarkup::buttons([
				new InlineKeyboardButton(["text" => "OK", "callback_data" => "ok"]),
			]),
		);

		$body = (string)$history[0]["request"]->getBody();
		self::assertStringContainsString('[{"type":"bold","offset":0,"length":5}]', $body);
		self::assertStringContainsString('{"inline_keyboard":[[{"text":"OK","callback_data":"ok"}]]}', $body);
	}

	private function createServer(array &$history): TeleBrownServer
	{
		$mock = new MockHandler([new GuzzleResponse(200, [], '{"ok":true,"result":{"message_id":1}}')]);
		$handler = HandlerStack::create($mock);
		$handler->push(Middleware::history($history));

		return new class("https://telegram.example.test", "123:TOKEN", $handler) extends TeleBrownServer {
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
