<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity\ChatMember;

use Haikiri\TeleBrown\Entity\User;
use Haikiri\TeleBrown\Entity\ChatMember;

/**
 * ChatMemberLeft – Represents a chat member that isn't currently a member of the chat, but may join it themselves.
 * @see https://core.telegram.org/bots/api#chatmemberleft
 */
class ChatMemberLeft extends ChatMember
{
	protected static string $status = "left";

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public static function getStatus(): string
	{
		return self::$status;
	}

	public function getUser(): User
	{
		return new User($this->getData("user"));
	}

}
