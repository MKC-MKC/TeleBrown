<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects\ChatMember;

use Haikiri\TeleBrown\Objects\User;
use Haikiri\TeleBrown\Objects\ChatMember;

/**
 * ChatMemberRestricted – Represents a chat member that is under certain restrictions in the chat. Supergroups only.
 * @see https://core.telegram.org/bots/api#chatmemberrestricted
 */
class ChatMemberRestricted extends ChatMember
{
	protected static string $status = "restricted";

	public static function getStatus(): string
	{
		return self::$status;
	}

	public function getUser(): User
	{
		$data = (array)$this->getData("user", []);
		return new User($data);
	}

	public function getUntilDate(): int
	{
		return (int)$this->getData("until_date", 0);
	}

}
