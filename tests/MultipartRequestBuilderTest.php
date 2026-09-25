<?php

declare(strict_types=1);

use Haikiri\TeleBrown\Builders\MultipartRequestBuilder;
use PHPUnit\Framework\TestCase;

final class MultipartRequestBuilderTest extends TestCase
{

	public function testExistingPathStaysTextOutsideFileParameters(): void
	{
		$source = tempnam(sys_get_temp_dir(), "telebrown-upload-");
		self::assertNotFalse($source);
		file_put_contents($source, "upload-content");
		$parts = [];

		try {
			$parts = MultipartRequestBuilder::build([
				"document" => $source,
				"thumbnail" => $source,
				"cover" => $source,
				"certificate" => $source,
				"caption" => $source,
				"chat_id" => $source,
				"business_connection_id" => $source,
				"photo" => "telegram-file-id",
				"video" => "https://example.test/video.mp4",
			]);

			foreach (array_slice($parts, 0, 4) as $part) {
				self::assertIsResource($part["contents"]);
				self::assertSame("upload-content", stream_get_contents($part["contents"]));
				self::assertSame(basename($source), $part["filename"]);
			}

			foreach (array_slice($parts, 4, 3) as $part) {
				self::assertSame($source, $part["contents"]);
				self::assertArrayNotHasKey("filename", $part);
			}

			self::assertSame("telegram-file-id", $parts[7]["contents"]);
			self::assertSame("https://example.test/video.mp4", $parts[8]["contents"]);
		} finally {
			foreach ($parts as $part) {
				if (is_resource($part["contents"])) fclose($part["contents"]);
			}
			unlink($source);
		}
	}

	public function testMultipartPreservesFalseZeroEmptyStringAndArrays(): void
	{
		$parts = MultipartRequestBuilder::build([
			"protect_content" => false,
			"has_spoiler" => true,
			"start_timestamp" => 0,
			"caption" => "",
			"caption_entities" => [],
			"thumbnail" => null,
		]);

		self::assertSame([
			["name" => "protect_content", "contents" => "false"],
			["name" => "has_spoiler", "contents" => "true"],
			["name" => "start_timestamp", "contents" => "0"],
			["name" => "caption", "contents" => ""],
			["name" => "caption_entities", "contents" => "[]"],
		], $parts);
	}

}
