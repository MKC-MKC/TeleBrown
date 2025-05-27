<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects\MessageOrigin;

use Haikiri\TeleBrown\Objects\User;
use Haikiri\TeleBrown\Objects\MessageOrigin;

/**
 * MessageOriginUser – The message was originally sent by a known user.
 * @see https://core.telegram.org/bots/api#messageoriginuser
 */
class MessageOriginUser extends MessageOrigin
{
	protected static string $type = "user";

	public static function getType(): string
	{
		return self::$type;
	}

	public function getDate(): int
	{
		return (int)$this->getData("date") ?? 0;
	}

	public function getSenderUser(): User
	{
		$data = (array)$this->getData("sender_user", []);
		return new User($data);
	}

}
