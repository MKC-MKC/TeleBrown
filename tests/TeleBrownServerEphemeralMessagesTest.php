<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Haikiri\TeleBrown\Enums\ParseModeEnum;
use Haikiri\TeleBrown\Enums;
use Haikiri\TeleBrown\Objects;
use Haikiri\TeleBrown\TeleBrownServer;
use PHPUnit\Framework\TestCase;

final class TeleBrownServerEphemeralMessagesTest extends TestCase
{

	public function testTextEditingSupportsEntitiesAndRichContent(): void
	{
		$history = [];
		$server = $this->createServer($history, true);
		$entities = [new Objects\MessageEntity(["type" => "bold", "offset" => 0, "length" => 1])];
		$preview = new Objects\LinkPreviewOptions(["is_disabled" => false]);

		self::assertTrue($server->editEphemeralMessageText("@example", 123, 42, "0", entities: $entities, linkPreviewOptions: $preview));

		$parts = $this->requestParts($history);
		self::assertSame("/bot123:TOKEN/editEphemeralMessageText", $history[0]["request"]->getUri()->getPath());
		self::assertSame("@example", $parts["chat_id"]["contents"]);
		self::assertSame("123", $parts["receiver_user_id"]["contents"]);
		self::assertSame("42", $parts["ephemeral_message_id"]["contents"]);
		self::assertSame("0", $parts["text"]["contents"]);
		self::assertSame([["type" => "bold", "offset" => 0, "length" => 1]], json_decode($parts["entities"]["contents"], true, 512, JSON_THROW_ON_ERROR));
		self::assertSame(["is_disabled" => false], json_decode($parts["link_preview_options"]["contents"], true, 512, JSON_THROW_ON_ERROR));
		self::assertArrayNotHasKey("rich_message", $parts);

		$history = [];
		$rich = new Objects\InputRichMessage(["html" => "<b>Rich</b>", "is_rtl" => false]);
		self::assertTrue($this->createServer($history, true)->editEphemeralMessageText(17, 123, 42, richMessage: $rich));
		$parts = $this->requestParts($history);
		self::assertArrayNotHasKey("text", $parts);
		self::assertSame($rich->getAsArray(), json_decode($parts["rich_message"]["contents"], true, 512, JSON_THROW_ON_ERROR));
	}

	public function testMediaEditingUploadsFileWithoutUploadingCaption(): void
	{
		$path = tempnam(sys_get_temp_dir(), "telebrown-ephemeral-");
		file_put_contents($path, "ephemeral-photo");
		try {
			$history = [];
			$media = new Objects\InputMedia(["type" => "photo", "media" => $path, "caption" => $path]);
			$markup = new Objects\InlineKeyboardMarkup(["inline_keyboard" => []]);

			self::assertTrue($this->createServer($history, true)->editEphemeralMessageMedia(17, 123, 42, $media, $markup));

			$parts = $this->requestParts($history);
			self::assertSame("/bot123:TOKEN/editEphemeralMessageMedia", $history[0]["request"]->getUri()->getPath());
			self::assertSame(["type" => "photo", "media" => "attach://media_media", "caption" => $path], json_decode($parts["media"]["contents"], true, 512, JSON_THROW_ON_ERROR));
			self::assertSame("ephemeral-photo", $parts["media_media"]["contents"]);
			self::assertSame(basename($path), $parts["media_media"]["filename"]);
			self::assertSame(["inline_keyboard" => []], json_decode($parts["reply_markup"]["contents"], true, 512, JSON_THROW_ON_ERROR));
			self::assertSame($path, $media->getMedia());
		} finally {
			unlink($path);
		}
	}

	public function testCaptionEditingPreservesEmptyCaptionAndFalse(): void
	{
		$history = [];
		$server = $this->createServer($history, true);

		self::assertTrue($server->editEphemeralMessageCaption(17, 123, 42, "", captionEntities: [], showCaptionAboveMedia: false));

		self::assertSame("/bot123:TOKEN/editEphemeralMessageCaption", $history[0]["request"]->getUri()->getPath());
		self::assertSame([
			"chat_id" => 17, "receiver_user_id" => 123, "ephemeral_message_id" => 42,
			"caption" => "", "caption_entities" => [], "show_caption_above_media" => false,
		], json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));

		$history = [];
		self::assertTrue($this->createServer($history, true)->editEphemeralMessageCaption(17, 123, 42, "<b>Caption</b>", parseMode: Enums\ParseModeEnum::HTML));
		self::assertSame("HTML", json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR)["parse_mode"]);
	}

	public function testReplyMarkupEditingSerializesButtonsAndAllowsRemoval(): void
	{
		foreach ([null, new Objects\InlineKeyboardMarkup(["inline_keyboard" => [[new Objects\InlineKeyboardButton(["text" => "Open", "url" => "https://example.com"])] ]])] as $markup) {
			$history = [];
			$server = $this->createServer($history, true);

			self::assertTrue($server->editEphemeralMessageReplyMarkup(17, 123, 42, $markup));

			$expected = ["chat_id" => 17, "receiver_user_id" => 123, "ephemeral_message_id" => 42];
			if ($markup !== null) {
				$expected["reply_markup"] = ["inline_keyboard" => [[["text" => "Open", "url" => "https://example.com"]]]];
			}
			self::assertSame("/bot123:TOKEN/editEphemeralMessageReplyMarkup", $history[0]["request"]->getUri()->getPath());
			self::assertSame($expected, json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));
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

	private function createServer(array &$history, mixed $result): TeleBrownServer
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
