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
	protected array $response = [];

	public function __construct(array $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array
	{
		return $this->response ?? [];
	}

	public function getUser(): User
	{
		return new User($this->getAsArray()["user"] ?? []);
	}

}
