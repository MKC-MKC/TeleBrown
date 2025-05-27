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

	public static function getType(): string
	{
		return self::$type;
	}

	public function getDate(): int
	{
		return (int)$this->getData("date");
	}

	public function getSenderUserName(): string
	{
		return (string)$this->getData("sender_user_name", "");
	}

}
