<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Haikiri\TeleBrown\Enums\ParseModeEnum;
use Haikiri\TeleBrown\Objects;
use Haikiri\TeleBrown\TeleBrownServer;
use PHPUnit\Framework\TestCase;

final class TeleBrownServerRichMessagesTest extends TestCase
{

	public function testRichMessageUploadsReferencedMedia(): void
	{
		$path = tempnam(sys_get_temp_dir(), "telebrown-rich-");
		file_put_contents($path, "rich-media");
		try {
			$history = [];
			$server = $this->createServer($history, ["message_id" => 49, "rich_message" => ["blocks" => []]]);
			$rich = new Objects\InputRichMessage([
				"html" => '<p><img src="tg://photo?id=pic"></p>',
				"media" => [new Objects\InputRichMessageMedia(["id" => "pic", "media" => new Objects\InputMedia(["type" => "photo", "media" => $path])])],
				"is_rtl" => false,
			]);
			$message = $server->sendRichMessage(17, $rich, disableNotification: false, messageThreadId: 5, replyParameters: new Objects\ReplyParameters(["message_id" => 1]));
			self::assertSame(49, $message->getId());
			self::assertSame("/bot123:TOKEN/sendRichMessage", $history[0]["request"]->getUri()->getPath());
			$parts = $this->requestParts($history);
			$data = json_decode($parts["rich_message"]["contents"], true, 512, JSON_THROW_ON_ERROR);
			$attachment = $data["media"][0]["media"]["media"];
			self::assertStringStartsWith("attach://", $attachment);
			self::assertSame("rich-media", $parts[substr($attachment, 9)]["contents"]);
			self::assertSame("pic", $data["media"][0]["id"]);
			self::assertSame($rich->getHtml(), $data["html"]);
			self::assertFalse($data["is_rtl"]);
			self::assertSame("false", $parts["disable_notification"]["contents"]);
			self::assertSame("5", $parts["message_thread_id"]["contents"]);
			self::assertSame(["message_id" => 1], json_decode($parts["reply_parameters"]["contents"], true, 512, JSON_THROW_ON_ERROR));
			self::assertSame($path, $rich->getAsArray()["media"][0]["media"]["media"]);
		} finally {
			unlink($path);
		}
	}

	public function testRichDraftUsesJsonAndPreservesStopOptions(): void
	{
		$history = [];
		$server = $this->createServer($history, true);
		$rich = new Objects\InputRichMessage([
			"markdown" => "**Text**", "is_rtl" => false,
			"media" => [new Objects\InputRichMessageMedia(["id" => "voice", "media" => new Objects\InputMedia(["type" => "voice_note", "media" => "file-id", "duration" => 8])])],
		]);
		self::assertTrue($server->sendRichMessageDraft(17, 1, $rich, messageThreadId: 5, canStop: true, keepOnStop: false));
		$request = $history[0]["request"];
		self::assertSame("application/json", $request->getHeaderLine("Content-Type"));
		self::assertSame("/bot123:TOKEN/sendRichMessageDraft", $request->getUri()->getPath());
		self::assertSame([
			"chat_id" => 17, "draft_id" => 1, "rich_message" => $rich->getAsArray(),
			"message_thread_id" => 5, "can_stop" => true, "keep_on_stop" => false,
		], json_decode((string)$request->getBody(), true, 512, JSON_THROW_ON_ERROR));
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
