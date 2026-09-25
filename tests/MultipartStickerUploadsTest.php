<?php

declare(strict_types=1);

use Haikiri\TeleBrown\Builders\MultipartRequestBuilder;
use PHPUnit\Framework\TestCase;

final class MultipartStickerUploadsTest extends TestCase
{

	public function testStickerObjectsUploadOnlyStickerFields(): void
	{
		$path = tempnam(sys_get_temp_dir(), "telebrown-sticker-");
		file_put_contents($path, "sticker-content");
		$parts = [];
		try {
			$sticker = ["sticker" => $path, "format" => "static", "emoji_list" => ["🙂"], "keywords" => [$path]];
			$parts = MultipartRequestBuilder::build(["sticker" => $sticker, "stickers" => [$sticker, ["sticker" => "file-id"], ["sticker" => "https://example.test/sticker.webp"]]]);
			$values = array_column($parts, "contents", "name");
			self::assertSame("sticker-content", stream_get_contents($values["sticker_sticker"]));
			self::assertSame("sticker-content", stream_get_contents($values["stickers_0_sticker"]));
			$single = json_decode($values["sticker"], true, 512, JSON_THROW_ON_ERROR);
			$list = json_decode($values["stickers"], true, 512, JSON_THROW_ON_ERROR);
			self::assertSame("attach://sticker_sticker", $single["sticker"]);
			self::assertSame("attach://stickers_0_sticker", $list[0]["sticker"]);
			self::assertSame([$path], $list[0]["keywords"]);
			self::assertSame("file-id", $list[1]["sticker"]);
			self::assertSame("https://example.test/sticker.webp", $list[2]["sticker"]);
			self::assertCount(4, $parts);
		} finally {
			foreach ($parts as $part) {
				if (is_resource($part["contents"])) fclose($part["contents"]);
			}
			unlink($path);
		}
	}

}
