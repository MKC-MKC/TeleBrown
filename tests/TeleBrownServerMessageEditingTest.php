<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Haikiri\TeleBrown\Objects\InlineKeyboardButton;
use Haikiri\TeleBrown\Objects\InlineKeyboardMarkup;
use Haikiri\TeleBrown\Objects\Message;
use Haikiri\TeleBrown\Objects\MessageEntity;
use Haikiri\TeleBrown\TeleBrownServer;
use PHPUnit\Framework\TestCase;

final class TeleBrownServerMessageEditingTest extends TestCase
{

	public function testReplyMarkupEditsChatAndInlineMessagesAndRemovesButtons(): void
	{
		foreach ([false, true] as $inline) {
			$history = [];
			$message = ["message_id" => 42, "date" => 1788960000, "chat" => ["id" => 17, "type" => "private"]];
			$server = $this->createServer($history, $inline ? true : $message);
			$markup = $inline ? new InlineKeyboardMarkup(["inline_keyboard" => []]) : InlineKeyboardMarkup::buttons([
				new InlineKeyboardButton(["text" => "OK", "callback_data" => "0"]),
			]);

			$result = $server->editMessageReplyMarkup(
				chatId: $inline ? null : 17,
				messageId: $inline ? null : 42,
				replyMarkup: $markup,
				inlineMessageId: $inline ? "inline-id" : null,
				businessConnectionId: $inline ? null : "business-id",
			);

			self::assertSame($inline ? true : $message, $result instanceof Message ? $result->getAsArray() : $result);
			self::assertSame("/bot123:TOKEN/editMessageReplyMarkup", $history[0]["request"]->getUri()->getPath());
			$expected = $inline ? ["inline_message_id" => "inline-id"] : ["chat_id" => 17, "message_id" => 42, "business_connection_id" => "business-id"];
			$expected["reply_markup"] = $markup->getAsArray();
			self::assertEquals($expected, json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));
		}
	}

	public function testCaptionPreservesEmptyTextFalseAndNestedEntities(): void
	{
		foreach ([false, true] as $inline) {
			$history = [];
			$message = ["message_id" => 42, "caption" => "0"];
			$server = $this->createServer($history, $inline ? true : $message);
			$entities = $inline ? [] : [new MessageEntity(["type" => "bold", "offset" => 0, "length" => 1])];

			$result = $server->editMessageCaption(
				chatId: $inline ? null : 17,
				messageId: $inline ? null : 42,
				caption: $inline ? "" : "0",
				inlineMessageId: $inline ? "inline-id" : null,
				captionEntities: $entities,
				showCaptionAboveMedia: false,
			);

			self::assertSame($inline ? true : $message, $result instanceof Message ? $result->getAsArray() : $result);
			self::assertSame("/bot123:TOKEN/editMessageCaption", $history[0]["request"]->getUri()->getPath());
			$expected = $inline ? ["inline_message_id" => "inline-id"] : ["chat_id" => 17, "message_id" => 42];
			$expected += ["caption" => $inline ? "" : "0", "caption_entities" => $inline ? [] : [["type" => "bold", "offset" => 0, "length" => 1]], "show_caption_above_media" => false];
			self::assertEquals($expected, json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));
		}
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
