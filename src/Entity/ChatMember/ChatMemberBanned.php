<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity\ChatMember;

use Haikiri\TeleBrown\Entity\User;
use Haikiri\TeleBrown\Entity\ChatMember;

/**
 * ChatMemberBanned – Represents a chat member that was banned in the chat and can't return to the chat or view chat messages.
 * @see https://core.telegram.org/bots/api#chatmemberbanned
 */
class ChatMemberBanned extends ChatMember
{
	protected static string $status = "kicked";

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
