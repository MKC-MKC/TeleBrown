<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Haikiri\TeleBrown\Enums\ParseModeEnum;
use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects\EphemeralMessageParameters;
use Haikiri\TeleBrown\Objects\InlineKeyboardButton;
use Haikiri\TeleBrown\Objects\InlineKeyboardMarkup;
use Haikiri\TeleBrown\Objects\Message;
use Haikiri\TeleBrown\Objects\MessageEntity;
use Haikiri\TeleBrown\Objects\ReplyParameters;
use Haikiri\TeleBrown\Objects\SuggestedPostParameters;
use Haikiri\TeleBrown\TeleBrownServer;
use PHPUnit\Framework\TestCase;

final class TeleBrownServerMediaTest extends TestCase
{

	public function testFileIdsAndUrlsAreSentAsTextAndResponsesBecomeMessages(): void
	{
		foreach (["sendPhoto" => "photo", "sendVideo" => "video"] as $method => $field) {
			foreach (["telegram-file-id", "https://example.test/media"] as $source) {
				$history = [];
				$server = $this->createServer($history, $field);

				$message = $server->$method("@media", $source);

				self::assertInstanceOf(Message::class, $message);
				self::assertSame(42, $message->getId());
				self::assertSame("result-id", $message->getData($field === "photo" ? "photo.0.file_id" : "video.file_id"));
				self::assertSame("/bot123:TOKEN/" . $method, $history[0]["request"]->getUri()->getPath());
				self::assertSame([
					"chat_id" => ["contents" => "@media", "filename" => null],
					$field => ["contents" => $source, "filename" => null],
				], $this->requestParts($history));
			}
		}
	}

	public function testLocalMediaThumbnailAndCoverAreUploadedWhileCaptionStaysText(): void
	{
		$source = tempnam(sys_get_temp_dir(), "telebrown-media-");
		self::assertNotFalse($source);
		file_put_contents($source, "media-content");

		try {
			foreach (["sendPhoto" => "photo", "sendVideo" => "video"] as $method => $field) {
				$history = [];
				$server = $this->createServer($history, $field);
				$arguments = ["chatId" => 17, $field => $source, "caption" => $source];
				if ($field === "video") {
					$arguments["thumbnail"] = $source;
					$arguments["cover"] = $source;
				}

				$server->$method(...$arguments);
				$parts = $this->requestParts($history);

				foreach ($field === "video" ? ["video", "thumbnail", "cover"] : ["photo"] as $fileField) {
					self::assertSame([
						"contents" => "media-content", "filename" => basename($source),
					], $parts[$fileField]);
				}
				self::assertSame(["contents" => $source, "filename" => null], $parts["caption"]);
			}
		} finally {
			unlink($source);
		}
	}

	public function testMediaParametersAreSerializedWithoutLosingFalseOrZero(): void
	{
		foreach (["sendPhoto" => "photo", "sendVideo" => "video"] as $method => $field) {
			$history = [];
			$server = $this->createServer($history, $field);
			$arguments = [
				"chatId" => -1001234567890,
				$field => "telegram-file-id",
				"businessConnectionId" => "business-id",
				"messageThreadId" => 42,
				"directMessagesTopicId" => 73,
				"caption" => "Caption",
				"captionEntities" => [new MessageEntity(["type" => "bold", "offset" => 0, "length" => 7])],
				"showCaptionAboveMedia" => true,
				"hasSpoiler" => false,
				"disableNotification" => false,
				"protectContent" => true,
				"allowPaidBroadcast" => false,
				"messageEffectId" => "effect-id",
				"suggestedPostParameters" => new SuggestedPostParameters(["send_date" => 1788960000]),
				"replyParameters" => new ReplyParameters(["message_id" => 41]),
				"replyMarkup" => InlineKeyboardMarkup::buttons([
					new InlineKeyboardButton(["text" => "OK", "callback_data" => "ok"]),
				]),
			];
			$expected = [
				"chat_id" => "-1001234567890",
				$field => "telegram-file-id",
				"business_connection_id" => "business-id",
				"message_thread_id" => "42",
				"direct_messages_topic_id" => "73",
				"caption" => "Caption",
				"caption_entities" => '[{"type":"bold","offset":0,"length":7}]',
				"show_caption_above_media" => "true",
				"has_spoiler" => "false",
				"disable_notification" => "false",
				"protect_content" => "true",
				"allow_paid_broadcast" => "false",
				"message_effect_id" => "effect-id",
				"suggested_post_parameters" => '{"send_date":1788960000}',
				"reply_parameters" => '{"message_id":41}',
				"reply_markup" => '{"inline_keyboard":[[{"text":"OK","callback_data":"ok"}]]}',
			];
			if ($field === "video") {
				$arguments += ["duration" => 8, "width" => 640, "height" => 480, "cover" => "cover-id", "startTimestamp" => 0, "supportsStreaming" => true];
				$expected += ["duration" => "8", "width" => "640", "height" => "480", "cover" => "cover-id", "start_timestamp" => "0", "supports_streaming" => "true"];
			}

			$server->$method(...$arguments);
			$actual = array_map(static fn(array $part): string => $part["contents"], $this->requestParts($history));
			ksort($expected);
			ksort($actual);
			self::assertSame($expected, $actual);
		}
	}

	public function testEphemeralParametersAndParseModeAreSentForBothMethods(): void
	{
		$parameters = new EphemeralMessageParameters([
			"receiver_user_id" => 123456789,
			"callback_query_id" => "callback-id",
			"replace_callback_query_message" => false,
		]);
		self::assertSame(123456789, $parameters->getReceiverUserId());
		self::assertSame("callback-id", $parameters->getCallbackQueryId());
		self::assertFalse($parameters->isReplaceCallbackQueryMessage());
		self::assertNull((new EphemeralMessageParameters(["receiver_user_id" => 17]))->getCallbackQueryId());
		self::assertTrue((new EphemeralMessageParameters(["replace_callback_query_message" => true]))->isReplaceCallbackQueryMessage());

		foreach (["sendPhoto" => "photo", "sendVideo" => "video"] as $method => $field) {
			$history = [];
			$server = $this->createServer($history, $field);

			$server->$method(
				-1001234567890,
				"telegram-file-id",
				caption: "<b>Caption</b>",
				parseMode: ParseModeEnum::HTML,
				ephemeralMessageParameters: $parameters,
			);

			$parts = $this->requestParts($history);
			self::assertSame("HTML", $parts["parse_mode"]["contents"]);
			self::assertArrayNotHasKey("caption_entities", $parts);
			self::assertSame($parameters->getAsArray(), json_decode($parts["ephemeral_message_parameters"]["contents"], true, 512, JSON_THROW_ON_ERROR));
		}
	}

	public function testMediaErrorsArePropagated(): void
	{
		foreach (["sendPhoto" => "photo", "sendVideo" => "video"] as $method => $field) {
			$history = [];
			$server = $this->createServer($history, $field, new GuzzleResponse(
				400, [], '{"ok":false,"error_code":400,"description":"Bad Request: wrong file identifier/HTTP URL specified"}',
			));

			try {
				$server->$method(17, "bad-file-id");
				self::fail("Expected a Telegram API error");
			} catch (TelegramMainException $e) {
				self::assertSame(400, $e->getCode());
				self::assertSame("Bad Request: wrong file identifier/HTTP URL specified", $e->getMessage());
			}
		}
	}

	private function requestParts(array $history): array
	{
		$request = $history[0]["request"];
		self::assertMatchesRegularExpression('/^multipart\/form-data; boundary=.+$/', $request->getHeaderLine("Content-Type"));
		preg_match('/boundary=(.+)$/', $request->getHeaderLine("Content-Type"), $boundary);
		$parts = [];

		foreach (explode("--" . $boundary[1], (string)$request->getBody()) as $part) {
			if (!str_contains($part, "Content-Disposition:")) continue;
			[$headers, $contents] = explode("\r\n\r\n", $part, 2);
			preg_match('/name="([^"]+)"/', $headers, $name);
			preg_match('/filename="([^"]+)"/', $headers, $filename);
			$parts[$name[1]] = ["contents" => substr($contents, 0, -2), "filename" => $filename[1] ?? null];
		}

		return $parts;
	}

	private function createServer(array &$history, string $field, ?GuzzleResponse $response = null): TeleBrownServer
	{
		$media = ["file_id" => "result-id", "file_unique_id" => "unique-id", "width" => 640, "height" => 480];
		$mock = new MockHandler([$response ?? new GuzzleResponse(200, [], json_encode([
			"ok" => true, "result" => [
				"message_id" => 42, "date" => 1788960000, "chat" => ["id" => 17, "type" => "private"],
				$field => $field === "photo" ? [$media] : $media + ["duration" => 8],
			],
		], JSON_THROW_ON_ERROR))]);
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
