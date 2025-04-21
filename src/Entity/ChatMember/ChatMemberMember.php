<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity\ChatMember;

use Haikiri\TeleBrown\Entity\User;
use Haikiri\TeleBrown\Entity\ChatMember;

/**
 * ChatMemberMember – Represents a chat member that has no additional privileges or restrictions.
 * @see https://core.telegram.org/bots/api#chatmembermember
 */
class ChatMemberMember extends ChatMember
{
	protected static string $status = "member";
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
