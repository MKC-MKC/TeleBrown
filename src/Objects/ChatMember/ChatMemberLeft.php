<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects\ChatMember;

use Haikiri\TeleBrown\Objects\User;
use Haikiri\TeleBrown\Objects\ChatMember;

/**
 * ChatMemberLeft – Represents a chat member that isn't currently a member of the chat, but may join it themselves.
 * @see https://core.telegram.org/bots/api#chatmemberleft
 */
class ChatMemberLeft extends ChatMember
{
	protected static string $status = "left";

	public static function getStatus(): string
	{
		return self::$status;
	}

	public function getUser(): User
	{
		$data = (array)$this->getData("user", []);
		return new User($data);
	}

}
