<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects\InlineKeyboardButton;
use Haikiri\TeleBrown\Objects\InlineKeyboardMarkup;
use Haikiri\TeleBrown\Objects\InlineQueryResultsButton;
use Haikiri\TeleBrown\Objects\InputRichMessage;
use Haikiri\TeleBrown\Objects\MessageEntity;
use Haikiri\TeleBrown\Objects\WebAppInfo;
use Haikiri\TeleBrown\TeleBrownServer;
use PHPUnit\Framework\TestCase;

final class TeleBrownServerInlineQueryTest extends TestCase
{

	public function testEmptyResultsAndOptionalParameters(): void
	{
		$history = [];
		$server = $this->createServer($history);

		self::assertTrue($server->answerInlineQuery("query", []));
		self::assertSame("https://api.telegram.org/bot123:TOKEN/answerInlineQuery", (string)$history[0]["request"]->getUri());
		self::assertSame(["inline_query_id" => "query", "results" => []], json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));
	}

	public function testAllResultTypesAreSentAsJsonObjects(): void
	{
		$history = [];
		$server = $this->createServer($history);
		$results = [
			["type" => "article", "title" => "Article", "input_message_content" => ["message_text" => "Text"]],
			["type" => "photo", "photo_url" => "https://example.com/photo.jpg", "thumbnail_url" => "https://example.com/thumb.jpg"],
			["type" => "gif", "gif_url" => "https://example.com/a.gif", "thumbnail_url" => "https://example.com/thumb.jpg"],
			["type" => "mpeg4_gif", "mpeg4_url" => "https://example.com/a.mp4", "thumbnail_url" => "https://example.com/thumb.jpg"],
			["type" => "video", "video_url" => "https://example.com/a.mp4", "mime_type" => "video/mp4", "thumbnail_url" => "https://example.com/thumb.jpg", "title" => "Video"],
			["type" => "audio", "audio_url" => "https://example.com/a.mp3", "title" => "Audio"],
			["type" => "voice", "voice_url" => "https://example.com/a.ogg", "title" => "Voice"],
			["type" => "document", "document_url" => "https://example.com/a.pdf", "mime_type" => "application/pdf", "title" => "Document"],
			["type" => "location", "latitude" => 55.75, "longitude" => 37.61, "title" => "Location"],
			["type" => "venue", "latitude" => 55.75, "longitude" => 37.61, "title" => "Venue", "address" => "Address"],
			["type" => "contact", "phone_number" => "+123456789", "first_name" => "Name"],
			["type" => "game", "game_short_name" => "game"],
			["type" => "audio", "audio_file_id" => "audio-id"],
			["type" => "document", "document_file_id" => "document-id", "title" => "Document"],
			["type" => "gif", "gif_file_id" => "gif-id"],
			["type" => "mpeg4_gif", "mpeg4_file_id" => "mpeg4-id"],
			["type" => "photo", "photo_file_id" => "photo-id"],
			["type" => "sticker", "sticker_file_id" => "sticker-id"],
			["type" => "video", "video_file_id" => "video-id", "title" => "Video"],
			["type" => "voice", "voice_file_id" => "voice-id", "title" => "Voice"],
		];
		foreach ($results as $index => &$result) {
			$result["id"] = (string)$index;
		}
		unset($result);
		$button = new InlineQueryResultsButton(["text" => "Connect", "start_parameter" => "connect"]);

		self::assertTrue($server->answerInlineQuery("query", $results, cacheTime: 0, isPersonal: false, nextOffset: "", button: $button));
		self::assertSame([
			"inline_query_id" => "query", "results" => $results, "cache_time" => 0,
			"is_personal" => false, "next_offset" => "", "button" => ["text" => "Connect", "start_parameter" => "connect"],
		], json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));
	}

	public function testMessageContentsAndNestedModels(): void
	{
		$history = [];
		$server = $this->createServer($history);
		$contents = [
			["message_text" => "Bold", "entities" => [new MessageEntity(["type" => "bold", "offset" => 0, "length" => 4])]],
			["rich_message" => new InputRichMessage(["html" => "<b>Rich</b>", "is_rtl" => false])],
			["latitude" => 55.75, "longitude" => 37.61, "horizontal_accuracy" => 0],
			["latitude" => 55.75, "longitude" => 37.61, "title" => "Venue", "address" => "Address"],
			["phone_number" => "+123456789", "first_name" => "Name"],
			["title" => "Invoice", "description" => "Product", "payload" => "order", "currency" => "XTR", "provider_token" => "", "prices" => [["label" => "Product", "amount" => 1]]],
		];
		$results = [];
		foreach ($contents as $index => $content) {
			$results[] = [
				"type" => "article", "id" => (string)$index, "title" => "Result",
				"input_message_content" => $content,
				"reply_markup" => InlineKeyboardMarkup::buttons([new InlineKeyboardButton(["text" => "Open", "callback_data" => "open"])]),
			];
		}
		$button = new InlineQueryResultsButton(["text" => "App", "web_app" => new WebAppInfo(["url" => "https://example.com/app"])]);

		self::assertTrue($server->answerInlineQuery("query", $results, button: $button));
		$body = json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR);
		$contents[0]["entities"] = [["type" => "bold", "offset" => 0, "length" => 4]];
		$contents[1]["rich_message"] = ["html" => "<b>Rich</b>", "is_rtl" => false];
		self::assertSame($contents, array_column($body["results"], "input_message_content"));
		foreach ($body["results"] as $result) {
			self::assertSame(["inline_keyboard" => [[["text" => "Open", "callback_data" => "open"]]]], $result["reply_markup"]);
		}
		self::assertSame(["text" => "App", "web_app" => ["url" => "https://example.com/app"]], $body["button"]);
	}

	public function testTelegramErrorIsPropagated(): void
	{
		$history = [];
		$server = $this->createServer($history, new GuzzleResponse(400, [], '{"ok":false,"error_code":400,"description":"Bad Request: query is too old"}'));

		$this->expectException(TelegramMainException::class);
		$this->expectExceptionCode(400);
		$this->expectExceptionMessage("Bad Request: query is too old");
		$server->answerInlineQuery("expired", []);
	}

	private function createServer(array &$history, GuzzleResponse|null $response = null): TeleBrownServer
	{
		$handler = HandlerStack::create(new MockHandler([$response ?? new GuzzleResponse(200, [], '{"ok":true,"result":true}')]));
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
