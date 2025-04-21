<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity\ChatMember;

use Haikiri\TeleBrown\Entity\User;
use Haikiri\TeleBrown\Entity\ChatMember;

/**
 * ChatMemberRestricted – Represents a chat member that is under certain restrictions in the chat. Supergroups only.
 * @see https://core.telegram.org/bots/api#chatmemberrestricted
 */
class ChatMemberRestricted extends ChatMember
{
	protected static string $status = "";
	private array $response;

	public function __construct(array $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array
	{
		return $this->response ?? [];
	}

	public static function getStatus(): string
	{
		return self::$status;
	}

	public function getUser(): User
	{
		return new User($this->getAsArray()["user"] ?? []);
	}

	public function getUntilDate(): int
	{
		return (int)$this->getAsArray()["until_date"] ?? 0;
	}

}
