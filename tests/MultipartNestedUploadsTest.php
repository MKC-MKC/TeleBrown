<?php

declare(strict_types=1);

use Haikiri\TeleBrown\Builders\MultipartRequestBuilder;
use PHPUnit\Framework\TestCase;

final class MultipartNestedUploadsTest extends TestCase
{

	private string $source;
	private array $parts = [];

	protected function setUp(): void
	{
		$this->source = tempnam(sys_get_temp_dir(), "telebrown-nested-");
		file_put_contents($this->source, "nested-upload");
	}

	protected function tearDown(): void
	{
		foreach ($this->parts as $part) {
			if (is_resource($part["contents"])) fclose($part["contents"]);
		}
		unlink($this->source);
	}

	public function testAlbumFilesHaveDistinctAttachmentNamesAndCaptionsStayText(): void
	{
		$this->parts = MultipartRequestBuilder::build(["media" => [
			["type" => "photo", "media" => $this->source, "caption" => $this->source],
			["type" => "video", "media" => $this->source, "thumbnail" => $this->source, "cover" => $this->source],
			["type" => "live_photo", "media" => $this->source, "photo" => $this->source],
			["type" => "audio", "media" => "file-id", "thumbnail" => $this->source, "title" => $this->source],
			["type" => "document", "media" => "https://example.test/file.pdf"],
		]]);
		$media = $this->decode("media");
		foreach (["0_media", "1_media", "1_thumbnail", "1_cover", "2_media", "2_photo", "3_thumbnail"] as $suffix) {
			[$index, $field] = explode("_", $suffix, 2);
			$this->assertAttachment($media[(int)$index][$field], "media_" . $suffix);
		}
		self::assertSame($this->source, $media[0]["caption"]);
		self::assertSame($this->source, $media[3]["title"]);
		self::assertSame("file-id", $media[3]["media"]);
		self::assertSame("https://example.test/file.pdf", $media[4]["media"]);
		self::assertCount(8, $this->parts);
	}

	public function testProfilePhotosAndLivePhotoUseTheirFileFields(): void
	{
		foreach (["static" => "photo", "animated" => "animation"] as $type => $field) {
			$parts = MultipartRequestBuilder::build(["photo" => ["type" => $type, $field => $this->source, "main_frame_timestamp" => 0]]);
			$this->parts = array_merge($this->parts, $parts);
			$photo = json_decode($parts[1]["contents"], true, 512, JSON_THROW_ON_ERROR);
			$this->assertAttachment($photo[$field], "photo_" . $field);
			self::assertSame(0, $photo["main_frame_timestamp"]);
		}
		$parts = MultipartRequestBuilder::build(["live_photo" => $this->source]);
		$this->parts = array_merge($this->parts, $parts);
		$this->assertAttachment("attach://live_photo", "live_photo");
	}

	public function testPollUploadsOnlyDeclaredMediaFields(): void
	{
		$this->parts = MultipartRequestBuilder::build([
			"media" => ["type" => "animation", "media" => $this->source, "thumbnail" => $this->source],
			"explanation_media" => ["type" => "photo", "media" => $this->source],
			"question" => $this->source,
			"options" => [
				["text" => $this->source, "media" => ["type" => "sticker", "media" => $this->source, "emoji" => $this->source]],
				["text" => "Link", "media" => ["type" => "link", "url" => $this->source]],
				["text" => "Location", "media" => ["type" => "location", "media" => $this->source]],
				["text" => "Venue", "media" => ["type" => "venue", "address" => $this->source]],
			],
		]);
		$media = $this->decode("media");
		$this->assertAttachment($media["media"], "media_media");
		$this->assertAttachment($media["thumbnail"], "media_thumbnail");
		$this->assertAttachment($this->decode("explanation_media")["media"], "explanation_media_media");
		$options = $this->decode("options");
		$this->assertAttachment($options[0]["media"]["media"], "options_0_media_media");
		self::assertSame($this->source, $options[0]["text"]);
		self::assertSame($this->source, $options[0]["media"]["emoji"]);
		self::assertSame($this->source, $options[1]["media"]["url"]);
		self::assertSame($this->source, $options[2]["media"]["media"]);
		self::assertSame($this->source, $options[3]["media"]["address"]);
		self::assertCount(8, $this->parts);
	}

	private function decode(string $name): array
	{
		$parts = array_column($this->parts, "contents", "name");
		return json_decode($parts[$name], true, 512, JSON_THROW_ON_ERROR);
	}

	private function assertAttachment(string $reference, string $name): void
	{
		self::assertSame("attach://" . $name, $reference);
		$parts = array_column($this->parts, null, "name");
		self::assertIsResource($parts[$name]["contents"]);
		self::assertSame("nested-upload", stream_get_contents($parts[$name]["contents"]));
		self::assertSame(basename($this->source), $parts[$name]["filename"]);
	}

}
