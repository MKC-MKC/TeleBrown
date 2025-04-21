<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity\MessageOrigin;

use Haikiri\TeleBrown\Entity\User;
use Haikiri\TeleBrown\Entity\MessageOrigin;

/**
 * MessageOriginUser – The message was originally sent by a known user.
 * @see https://core.telegram.org/bots/api#messageoriginuser
 */
class MessageOriginUser extends MessageOrigin
{
	protected static string $type = "user";
	private array $response;

	public function __construct(array $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array
	{
		return $this->response ?? [];
	}

	public static function getType(): string
	{
		return self::$type;
	}

	public function getDate(): int
	{
		return (int)$this->getAsArray()["date"] ?? 0;
	}

	public function getSenderUser(): User
	{
		return new User($this->getAsArray()["sender_user"] ?? []);
	}

}
