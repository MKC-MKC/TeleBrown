<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity\MessageOrigin;

use Haikiri\TeleBrown\Entity\MessageOrigin;

/**
 * MessageOriginHiddenUser – The message was originally sent by an unknown user.
 * @see https://core.telegram.org/bots/api#messageoriginhiddenuser
 */
class MessageOriginHiddenUser extends MessageOrigin
{
	protected static string $type = "hidden_user";
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

	public function getSenderUserName(): string
	{
		return (string)$this->getAsArray()["sender_user_name"] ?? "";
	}

}
