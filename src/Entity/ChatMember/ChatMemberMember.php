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

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public static function getStatus(): string
	{
		return self::$status;
	}

	public function getUser(): ?User
	{
		return ($data = $this->getData("user")) && is_array($data) ? new User($data) : null;
	}

	public function getUntilDate(): int
	{
		return (int)$this->getData("until_date") ?? 0;
	}

}
