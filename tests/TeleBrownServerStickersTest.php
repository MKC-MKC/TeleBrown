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

final class TeleBrownServerStickersTest extends TestCase
{

	public function testCustomEmojiResultsAreHydratedAndCanBeEmpty(): void
	{
		$history = [];
		$stickers = $this->createServer($history, [["file_id" => "sticker-id", "file_unique_id" => "unique-id", "type" => "custom_emoji", "width" => 100, "height" => 100, "is_animated" => false, "is_video" => false, "custom_emoji_id" => "123456"]])->getCustomEmojiStickers(["123456"]);
		self::assertInstanceOf(Objects\Sticker::class, $stickers[0]);
		self::assertSame("sticker-id", $stickers[0]->getFileId());
		self::assertSame("123456", $stickers[0]->getCustomEmojiId());
		self::assertSame(["custom_emoji_ids" => ["123456"]], json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));
		$history = [];
		self::assertSame([], $this->createServer($history, [])->getCustomEmojiStickers(["123456"]));
	}

	public function testStickerUploadSendsFileAndReturnsReusableIdentifier(): void
	{
		$path = tempnam(sys_get_temp_dir(), "telebrown-sticker-");
		self::assertNotFalse($path);
		file_put_contents($path, "sticker-file-content");
		try {
			$history = [];
			$file = $this->createServer($history, ["file_id" => "uploaded-id", "file_unique_id" => "unique-id"])->uploadStickerFile(123, $path, "static");
			self::assertSame("uploaded-id", $file->getFileId());
			$body = (string)$history[0]["request"]->getBody();
			self::assertStringContainsString('name="sticker"; filename="' . basename($path) . '"', $body);
			self::assertStringContainsString("sticker-file-content", $body);
			self::assertStringContainsString('name="sticker_format"', $body);
		} finally {
			unlink($path);
		}
	}

	public function testNewSetSerializesNestedMaskAndFalseValues(): void
	{
		$history = [];
		$sticker = new Objects\InputSticker([
			"sticker" => "file-id", "format" => "static", "emoji_list" => ["🙂"],
			"mask_position" => new Objects\MaskPosition(["point" => "eyes", "x_shift" => 0.0, "y_shift" => 0.0, "scale" => 1.0]),
			"keywords" => [],
		]);
		self::assertSame(0.0, $sticker->getMaskPosition()->getXShift());
		self::assertSame([], $sticker->getKeywords());
		self::assertTrue($this->createServer($history, true)->createNewStickerSet(123, "animals_by_example_bot", "Animals", [$sticker], "mask", false));
		$body = (string)$history[0]["request"]->getBody();
		self::assertStringContainsString(json_encode([$sticker->getAsArray()], JSON_THROW_ON_ERROR), $body);
		self::assertMatchesRegularExpression('/name="needs_repainting"\r\n(?:[^\r\n]+\r\n)*\r\nfalse\r\n/', $body);
	}

	private function createServer(array &$history, mixed $result): TeleBrownServer
	{
		$mock = new MockHandler([new GuzzleResponse(200, [], json_encode(["ok" => true, "result" => $result], JSON_THROW_ON_ERROR))]);
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
