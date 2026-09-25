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

	public function testsendAudioUploadsFileAndPreservesFalse(): void
	{
		$path = tempnam(sys_get_temp_dir(), "telebrown-media-");
		file_put_contents($path, "media-contents");
		try {
			$history = [];
			$server = $this->createServer($history, ["message_id" => 42]);
			$message = $server->sendAudio(17, $path, duration: 0, disableNotification: false, caption: $path, parseMode: ParseModeEnum::HTML);
			$parts = $this->requestParts($history);
			self::assertSame(42, $message->getId());
			self::assertSame("/bot123:TOKEN/sendAudio", $history[0]["request"]->getUri()->getPath());
			self::assertSame("media-contents", $parts["audio"]["contents"]);
			self::assertSame(basename($path), $parts["audio"]["filename"]);
			self::assertSame("0", $parts["duration"]["contents"]);
			self::assertSame("false", $parts["disable_notification"]["contents"]);
			self::assertSame($path, $parts["caption"]["contents"]);
			self::assertNull($parts["caption"]["filename"]);
			self::assertSame("HTML", $parts["parse_mode"]["contents"]);
		} finally {
			unlink($path);
		}
	}

	public function testsendAnimationUploadsFileAndPreservesFalse(): void
	{
		$path = tempnam(sys_get_temp_dir(), "telebrown-media-");
		file_put_contents($path, "media-contents");
		try {
			$history = [];
			$server = $this->createServer($history, ["message_id" => 42]);
			$message = $server->sendAnimation(17, $path, duration: 0, disableNotification: false, caption: $path, parseMode: ParseModeEnum::HTML);
			$parts = $this->requestParts($history);
			self::assertSame(42, $message->getId());
			self::assertSame("/bot123:TOKEN/sendAnimation", $history[0]["request"]->getUri()->getPath());
			self::assertSame("media-contents", $parts["animation"]["contents"]);
			self::assertSame(basename($path), $parts["animation"]["filename"]);
			self::assertSame("0", $parts["duration"]["contents"]);
			self::assertSame("false", $parts["disable_notification"]["contents"]);
			self::assertSame($path, $parts["caption"]["contents"]);
			self::assertNull($parts["caption"]["filename"]);
			self::assertSame("HTML", $parts["parse_mode"]["contents"]);
		} finally {
			unlink($path);
		}
	}

	public function testsendVideoNoteUploadsFileAndPreservesFalse(): void
	{
		$path = tempnam(sys_get_temp_dir(), "telebrown-media-");
		file_put_contents($path, "media-contents");
		try {
			$history = [];
			$server = $this->createServer($history, ["message_id" => 42]);
			$message = $server->sendVideoNote(17, $path, duration: 0, disableNotification: false, length: 0);
			$parts = $this->requestParts($history);
			self::assertSame(42, $message->getId());
			self::assertSame("/bot123:TOKEN/sendVideoNote", $history[0]["request"]->getUri()->getPath());
			self::assertSame("media-contents", $parts["video_note"]["contents"]);
			self::assertSame(basename($path), $parts["video_note"]["filename"]);
			self::assertSame("0", $parts["duration"]["contents"]);
			self::assertSame("false", $parts["disable_notification"]["contents"]);
			self::assertSame("0", $parts["length"]["contents"]);
		} finally {
			unlink($path);
		}
	}

	public function testsetMyProfilePhotoUploadsAnimatedProfile(): void
	{
		$path = tempnam(sys_get_temp_dir(), "telebrown-profile-");
		file_put_contents($path, "profile-video");
		try {
			$history = [];
			$server = $this->createServer($history, true);
			$photo = new Objects\InputProfilePhoto(["type" => "animated", "animation" => $path, "main_frame_timestamp" => 0.0]);
			self::assertTrue($server->setMyProfilePhoto($photo));
			$parts = $this->requestParts($history);
			self::assertSame("profile-video", $parts["photo_animation"]["contents"]);
			self::assertSame(["type" => "animated", "animation" => "attach://photo_animation", "main_frame_timestamp" => 0], json_decode($parts["photo"]["contents"], true, 512, JSON_THROW_ON_ERROR));
			self::assertSame($path, $photo->getAnimation());

		} finally {
			unlink($path);
		}
	}

	public function testsetBusinessAccountProfilePhotoUploadsAnimatedProfile(): void
	{
		$path = tempnam(sys_get_temp_dir(), "telebrown-profile-");
		file_put_contents($path, "profile-video");
		try {
			$history = [];
			$server = $this->createServer($history, true);
			$photo = new Objects\InputProfilePhoto(["type" => "animated", "animation" => $path, "main_frame_timestamp" => 0.0]);
			self::assertTrue($server->setBusinessAccountProfilePhoto("connection", $photo, isPublic: false));
			$parts = $this->requestParts($history);
			self::assertSame("profile-video", $parts["photo_animation"]["contents"]);
			self::assertSame(["type" => "animated", "animation" => "attach://photo_animation", "main_frame_timestamp" => 0], json_decode($parts["photo"]["contents"], true, 512, JSON_THROW_ON_ERROR));
			self::assertSame($path, $photo->getAnimation());
			self::assertSame("false", $parts["is_public"]["contents"]);
			self::assertSame("connection", $parts["business_connection_id"]["contents"]);
		} finally {
			unlink($path);
		}
	}

	public function testChecklistPreservesNestedTasksAndEntities(): void
	{
		$history = [];
		$server = $this->createServer($history, ["message_id" => 43]);
		$entity = new Objects\MessageEntity(["type" => "bold", "offset" => 0, "length" => 4]);
		$checklist = new Objects\InputChecklist([
			"title" => "List", "title_entities" => [$entity],
			"tasks" => [new Objects\InputChecklistTask(["id" => 1, "text" => "Task", "text_entities" => [$entity]])],
			"others_can_add_tasks" => false,
		]);
		self::assertSame(43, $server->sendChecklist("business", 17, $checklist, disableNotification: false)->getId());
		$body = json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR);
		self::assertSame("business", $body["business_connection_id"]);
		self::assertSame($checklist->getAsArray(), $body["checklist"]);
		self::assertFalse($body["disable_notification"]);
		self::assertSame("bold", $body["checklist"]["tasks"][0]["text_entities"][0]["type"]);
	}

	public function testLivePhotoUploadsBothParts(): void
	{
		$path = tempnam(sys_get_temp_dir(), "telebrown-live-");
		file_put_contents($path, "live-photo");
		try {
			$history = [];
			$server = $this->createServer($history, ["message_id" => 44]);
			self::assertSame(44, $server->sendLivePhoto(17, $path, $path, caption: $path, hasSpoiler: false)->getId());
			$parts = $this->requestParts($history);
			self::assertSame("live-photo", $parts["live_photo"]["contents"]);
			self::assertSame("live-photo", $parts["photo"]["contents"]);
			self::assertSame($path, $parts["caption"]["contents"]);
			self::assertNull($parts["caption"]["filename"]);
			self::assertSame("false", $parts["has_spoiler"]["contents"]);
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
