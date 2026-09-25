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

final class TeleBrownServerAdditionalMediaTest extends TestCase
{

	public function testsendVoiceUploadsFileAndPreservesFalse(): void
	{
		$path = tempnam(sys_get_temp_dir(), "telebrown-media-");
		file_put_contents($path, "media-contents");
		try {
			$history = [];
			$server = $this->createServer($history, ["message_id" => 42]);
			$message = $server->sendVoice(17, $path, duration: 0, disableNotification: false, caption: $path, parseMode: ParseModeEnum::HTML);
			$parts = $this->requestParts($history);
			self::assertSame(42, $message->getId());
			self::assertSame("/bot123:TOKEN/sendVoice", $history[0]["request"]->getUri()->getPath());
			self::assertSame("media-contents", $parts["voice"]["contents"]);
			self::assertSame(basename($path), $parts["voice"]["filename"]);
			self::assertSame("0", $parts["duration"]["contents"]);
			self::assertSame("false", $parts["disable_notification"]["contents"]);
			self::assertSame($path, $parts["caption"]["contents"]);
			self::assertNull($parts["caption"]["filename"]);
			self::assertSame("HTML", $parts["parse_mode"]["contents"]);
		} finally {
			unlink($path);
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
