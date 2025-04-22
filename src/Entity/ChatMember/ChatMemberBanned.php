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
