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
	protected static string $status = "restricted";

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
		return ($data = $this->getData("user")) && is_array($data) ? new User($data) : null;
	}

	public function getUntilDate(): int
	{
		return (int)$this->getData("until_date") ?? 0;
	}

}
