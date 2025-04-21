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

	public function isAnonymous(): bool
	{
		return ($this->getAsArray()["is_anonymous"] ?? false);
	}

	public function getCustomTitle(): string
	{
		return (string)$this->getAsArray()["custom_title"] ?? "";
	}

}
