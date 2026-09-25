<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects\InputMedia;
use Haikiri\TeleBrown\Objects\InlineKeyboardMarkup;
use Haikiri\TeleBrown\Objects\Message;
use Haikiri\TeleBrown\Objects\MessageEntity;
use Haikiri\TeleBrown\TeleBrownServer;
use PHPUnit\Framework\TestCase;

final class TeleBrownServerEditMediaTest extends TestCase
{

	public function testInlineMediaTypesUseJsonAndReturnTrue(): void
	{
		foreach (["animation", "audio", "document", "live_photo", "photo", "video"] as $type) {
			$history = [];
			$server = $this->createServer($history, true);
			$media = ["type" => $type, "media" => "file-id"];
			if ($type === "live_photo") $media["photo"] = "photo-file-id";

			self::assertTrue($server->editMessageMedia(new InputMedia($media), inlineMessageId: "INLINE"));
			self::assertSame("/bot123:TOKEN/editMessageMedia", $history[0]["request"]->getUri()->getPath());
			self::assertSame("application/json", $history[0]["request"]->getHeaderLine("Content-Type"));
			self::assertSame(
				["media" => $media, "inline_message_id" => "INLINE"],
				json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR),
			);
		}
	}

	public function testChatMediaReturnsMessageAndSerializesNestedObjects(): void
	{
		$history = [];
		$message = ["message_id" => 42, "date" => 1788960000, "chat" => ["id" => 17, "type" => "private"]];
		$server = $this->createServer($history, $message);
		$entity = ["type" => "bold", "offset" => 0, "length" => 7];
		$media = [
			"type" => "video", "media" => "https://example.test/video.mp4", "caption" => "Caption",
			"caption_entities" => [new MessageEntity($entity)], "start_timestamp" => 0, "has_spoiler" => false,
		];

		$result = $server->editMessageMedia(
			$media, chatId: 17, messageId: 42, businessConnectionId: "BUSINESS",
			replyMarkup: new InlineKeyboardMarkup(["inline_keyboard" => []]),
		);

		self::assertInstanceOf(Message::class, $result);
		self::assertSame($message, $result->getAsArray());
		$parts = $this->requestParts($history);
		self::assertSame("17", $parts["chat_id"]["contents"]);
		self::assertSame("42", $parts["message_id"]["contents"]);
		self::assertSame("BUSINESS", $parts["business_connection_id"]["contents"]);
		self::assertSame('{"inline_keyboard":[]}', $parts["reply_markup"]["contents"]);
		$expected = $media;
		$expected["caption_entities"] = [$entity];
		self::assertSame($expected, json_decode($parts["media"]["contents"], true, 512, JSON_THROW_ON_ERROR));
		self::assertArrayNotHasKey("inline_message_id", $parts);
	}

	public function testLocalMediaFilesAreAttachedWithoutChangingCaptionOrInput(): void
	{
		$source = tempnam(sys_get_temp_dir(), "telebrown-edit-media-");
		self::assertNotFalse($source);
		file_put_contents($source, "media-content");

		try {
			foreach (["video" => ["media", "thumbnail", "cover"], "live_photo" => ["media", "photo"]] as $type => $fields) {
				$history = [];
				$server = $this->createServer($history, ["message_id" => 42]);
				$media = ["type" => $type, "caption" => $source];
				foreach ($fields as $field) $media[$field] = $source;
				$original = $media;

				$server->editMessageMedia($media, chatId: 17, messageId: 42);

				self::assertSame($original, $media);
				$parts = $this->requestParts($history);
				$content = json_decode($parts["media"]["contents"], true, 512, JSON_THROW_ON_ERROR);
				self::assertSame($source, $content["caption"]);
				self::assertCount(count($fields) + 3, $parts);
				foreach ($fields as $field) {
					self::assertSame("attach://media_" . $field, $content[$field]);
					self::assertSame(["contents" => "media-content", "filename" => basename($source)], $parts["media_" . $field]);
				}
			}
		} finally {
			unlink($source);
		}
	}

	public function testInlineMediaDoesNotUploadLocalFiles(): void
	{
		$source = tempnam(sys_get_temp_dir(), "telebrown-inline-media-");
		self::assertNotFalse($source);
		file_put_contents($source, "media-content");

		try {
			$history = [];
			$server = $this->createServer($history, true, "Bad Request: wrong file identifier/HTTP URL specified");
			$media = ["type" => "photo", "media" => $source];

			try {
				$server->editMessageMedia($media, inlineMessageId: "INLINE");
				self::fail("Expected Telegram to reject a local path");
			} catch (TelegramMainException $e) {
				self::assertSame(400, $e->getCode());
			}

			self::assertSame("application/json", $history[0]["request"]->getHeaderLine("Content-Type"));
			self::assertSame(
				["media" => $media, "inline_message_id" => "INLINE"],
				json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR),
			);
		} finally {
			unlink($source);
		}
	}

	public function testMediaEditPropagatesTelegramError(): void
	{
		$history = [];
		$server = $this->createServer($history, true, "Bad Request: wrong file identifier/HTTP URL specified");

		$this->expectException(TelegramMainException::class);
		$this->expectExceptionCode(400);
		$this->expectExceptionMessage("Bad Request: wrong file identifier/HTTP URL specified");

		$server->editMessageMedia(["type" => "photo", "media" => "bad-id"], inlineMessageId: "INLINE");
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
