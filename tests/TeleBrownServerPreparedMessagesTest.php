<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Haikiri\TeleBrown\Objects;
use Haikiri\TeleBrown\TeleBrownServer;
use PHPUnit\Framework\TestCase;

final class TeleBrownServerPreparedMessagesTest extends TestCase
{

	public function testInlineResultPreservesNestedKeyboardAndEntities(): void
	{
		foreach (["answerWebAppQuery", "answerGuestQuery"] as $method) {
			$history = [];
			$server = $this->createServer($history, ["inline_message_id" => "inline-id"]);
			$result = [
				"type" => "article", "id" => "1", "title" => "Article",
				"input_message_content" => ["message_text" => "Bold", "entities" => [new Objects\MessageEntity(["type" => "bold", "offset" => 0, "length" => 4])]],
				"reply_markup" => Objects\InlineKeyboardMarkup::buttons([new Objects\InlineKeyboardButton(["text" => "Open", "callback_data" => "open"])]),
			];
			self::assertSame("inline-id", $server->$method("query-id", $result)->getInlineMessageId());
			$body = json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR);
			self::assertSame("query-id", $body[$method === "answerWebAppQuery" ? "web_app_query_id" : "guest_query_id"]);
			self::assertSame([["type" => "bold", "offset" => 0, "length" => 4]], $body["result"]["input_message_content"]["entities"]);
			self::assertSame([[ ["text" => "Open", "callback_data" => "open"] ]], $body["result"]["reply_markup"]["inline_keyboard"]);
		}
		self::assertNull((new Objects\SentWebAppMessage([]))->getInlineMessageId());
	}

	public function testPreparedMessagePermissionsAndExpiration(): void
	{
		$history = [];
		$server = $this->createServer($history, ["id" => "prepared-id", "expiration_date" => 1790000000]);
		$message = $server->savePreparedInlineMessage(17, ["type" => "article", "id" => "1", "title" => "Article", "input_message_content" => ["message_text" => "Text"]], allowUserChats: true, allowBotChats: false, allowGroupChats: false);
		self::assertSame("prepared-id", $message->getId());
		self::assertSame(1790000000, $message->getExpirationDate());
		$body = json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR);
		self::assertTrue($body["allow_user_chats"]);
		self::assertFalse($body["allow_bot_chats"]);
		self::assertFalse($body["allow_group_chats"]);
		self::assertArrayNotHasKey("allow_channel_chats", $body);
	}

	public function testPreparedButtonRetainsManagedBotRequest(): void
	{
		$history = [];
		$server = $this->createServer($history, ["id" => "button-id"]);
		$button = new Objects\KeyboardButton(["text" => "Bot", "request_managed_bot" => new Objects\KeyboardButtonRequestManagedBot(["request_id" => 0])]);
		self::assertSame("button-id", $server->savePreparedKeyboardButton(17, $button)->getId());
		$body = json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR);
		self::assertSame(["text" => "Bot", "request_managed_bot" => ["request_id" => 0]], $body["button"]);
	}

	private function createServer(array &$history, array $result): TeleBrownServer
	{
		$handler = HandlerStack::create(new MockHandler([new GuzzleResponse(200, [], json_encode(["ok" => true, "result" => $result], JSON_THROW_ON_ERROR))]));
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
