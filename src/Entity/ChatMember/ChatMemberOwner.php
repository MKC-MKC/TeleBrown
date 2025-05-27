<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity\ChatMember;

use Haikiri\TeleBrown\Entity\User;
use Haikiri\TeleBrown\Entity\ChatMember;

/**
 * ChatMemberOwner – Represents a chat member that owns the chat and has all administrator privileges.
 * @see https://core.telegram.org/bots/api#chatmemberowner
 */
class ChatMemberOwner extends ChatMember
{
	protected static string $status = "creator";

	public static function getStatus(): string
	{
		return self::$status;
	}

	public function getUser(): User
	{
		$data = (array)$this->getData("user", []);
		return new User($data);
	}

	public function isAnonymous(): bool
	{
		return (bool)$this->getData("is_anonymous", false);
	}

	public function getCustomTitle(): string
	{
		return (string)$this->getData("custom_title", "");
	}

}
