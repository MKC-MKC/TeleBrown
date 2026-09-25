<?php

declare(strict_types=1);

use Haikiri\TeleBrown\Objects\ChatMember;
use PHPUnit\Framework\TestCase;

final class ChatMemberFactoryTest extends TestCase
{

	public function testOfficialStatusesSelectMemberModels(): void
	{
		$classes = [
			"creator" => ChatMember\ChatMemberOwner::class,
			"administrator" => ChatMember\ChatMemberAdministrator::class,
			"member" => ChatMember\ChatMemberMember::class,
			"restricted" => ChatMember\ChatMemberRestricted::class,
			"left" => ChatMember\ChatMemberLeft::class,
			"kicked" => ChatMember\ChatMemberBanned::class,
		];
		foreach ($classes as $status => $class) {
			$data = ["status" => $status, "user" => ["id" => 42, "is_bot" => false, "first_name" => "User"]];

			$result = ChatMember::getChatMember($data);

			self::assertInstanceOf($class, $result);
			self::assertSame($data, $result->getAsArray());
		}
	}

}
