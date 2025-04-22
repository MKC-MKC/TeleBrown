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

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

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
		return ($data = $this->getData("sender_user")) && is_array($data) ? new User($data) : null;
	}

}
