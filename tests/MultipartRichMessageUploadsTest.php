<?php

declare(strict_types=1);

use Haikiri\TeleBrown\Builders\MultipartRequestBuilder;
use PHPUnit\Framework\TestCase;

final class MultipartRichMessageUploadsTest extends TestCase
{

	public function testRichMediaAndNestedBlocksUploadOnlyOfficialFileFields(): void
	{
		$path = tempnam(sys_get_temp_dir(), "telebrown-rich-");
		file_put_contents($path, "rich-content");
		$parts = [];
		try {
			$blocks = [];
			$media = [];
			foreach (["photo", "video", "audio", "animation", "document", "voice_note"] as $type) {
				$input = ["type" => $type, "media" => $path, "caption" => $path];
				$blocks[] = ["type" => $type, $type => $input];
				$media[] = ["id" => $type, "media" => $input];
			}
			foreach (["blockquote", "collage", "slideshow", "details"] as $type) {
				$blocks = [["type" => $type, "blocks" => $blocks]];
			}
			$blocks = [["type" => "list", "items" => [["blocks" => $blocks]]]];
			$fakeBlock = ["type" => "paragraph", "text" => $path, "blocks" => [["type" => "photo", "photo" => ["type" => "photo", "media" => $path]]]];
			$blocks[] = $fakeBlock;
			$media[] = ["id" => "existing", "media" => ["type" => "photo", "media" => "file-id"]];
			$media[] = ["id" => "remote", "media" => ["type" => "photo", "media" => "https://example.test/photo.jpg"]];
			$parts = MultipartRequestBuilder::build(["rich_message" => ["blocks" => $blocks, "media" => $media, "html" => $path, "markdown" => $path]]);
			$values = array_column($parts, "contents", "name");
			$message = json_decode($values["rich_message"], true, 512, JSON_THROW_ON_ERROR);
			self::assertSame($path, $message["html"]);
			self::assertSame($path, $message["markdown"]);
			self::assertSame($fakeBlock, $message["blocks"][1]);
			self::assertSame("file-id", $message["media"][6]["media"]["media"]);
			self::assertSame("https://example.test/photo.jpg", $message["media"][7]["media"]["media"]);
			$nested = $message["blocks"][0]["items"][0]["blocks"];
			for ($i = 0; $i < 4; $i++) $nested = $nested[0]["blocks"];
			foreach (["photo", "video", "audio", "animation", "document", "voice_note"] as $index => $type) {
				foreach ([$message["media"][$index]["media"], $nested[$index][$type]] as $input) {
					self::assertStringStartsWith("attach://", $input["media"]);
					self::assertSame("rich-content", stream_get_contents($values[substr($input["media"], 9)]));
					self::assertSame($path, $input["caption"]);
				}
			}
			self::assertCount(13, $parts);
		} finally {
			foreach ($parts as $part) {
				if (is_resource($part["contents"])) fclose($part["contents"]);
			}
			unlink($path);
		}
	}

}
