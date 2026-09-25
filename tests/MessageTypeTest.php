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

}
