<?php

declare(strict_types=1);

use Haikiri\TeleBrown\Enums\MessageTypesEnum;
use Haikiri\TeleBrown\Objects\Message;
use PHPUnit\Framework\TestCase;

final class MessageTypeTest extends TestCase
{

	public function testZeroTextIsRecognizedWithoutAffectingMessagesWithoutText(): void
	{
		self::assertSame(MessageTypesEnum::TEXT, (new Message(["text" => "0"]))->getType());
		self::assertSame(MessageTypesEnum::TEXT, (new Message(["text" => "Hello"]))->getType());
		self::assertSame(MessageTypesEnum::PHOTO, (new Message([
			"photo" => [["file_id" => "photo-id", "file_unique_id" => "unique-id", "width" => 100, "height" => 100]],
			"caption" => "0",
		]))->getType());
		self::assertNull((new Message([]))->getType());
	}

	public function testSpecificMediaTakesPriorityOverTelegramCompanionFields(): void
	{
		self::assertSame(MessageTypesEnum::ANIMATION, (new Message(["animation" => ["file_id" => "a"], "document" => ["file_id" => "a"]]))->getType());
		self::assertSame(MessageTypesEnum::VENUE, (new Message(["venue" => ["title" => "Cafe"], "location" => ["latitude" => 1, "longitude" => 2]]))->getType());
		self::assertSame(MessageTypesEnum::LIVE_PHOTO, (new Message(["live_photo" => ["file_id" => "v"], "photo" => [["file_id" => "p"]]]))->getType());
	}

	public function testEmptyServiceObjectsAreRecognized(): void
	{
		foreach (["video_chat_started", "write_access_allowed", "giveaway_created"] as $field) {
			$message = new Message(json_decode('{"' . $field . '":{}}', true, 512, JSON_THROW_ON_ERROR));
			self::assertSame($field, $message->getType()?->value);
		}
	}

}
