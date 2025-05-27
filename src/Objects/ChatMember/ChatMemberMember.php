<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects\ChatMember;

use Haikiri\TeleBrown\Objects\User;
use Haikiri\TeleBrown\Objects\ChatMember;

/**
 * ChatMemberMember – Represents a chat member that has no additional privileges or restrictions.
 * @see https://core.telegram.org/bots/api#chatmembermember
 */
class ChatMemberMember extends ChatMember
{
	protected static string $status = "member";

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
