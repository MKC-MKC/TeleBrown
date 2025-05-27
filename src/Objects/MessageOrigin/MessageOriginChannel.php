<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects\MessageOrigin;

use Haikiri\TeleBrown\Objects\Chat;
use Haikiri\TeleBrown\Objects\MessageOrigin;

/**
 * MessageOriginChannel – The message was originally sent to a channel chat.
 * @see https://core.telegram.org/bots/api#messageoriginchannel
 */
class MessageOriginChannel extends MessageOrigin
{
	protected static string $type = "channel";

	public static function getType(): string
	{
		return self::$type;
	}

	public function getDate(): int
	{
		return (int)$this->getData("date", 0);
	}

	public function getSenderUser(): Chat
	{
		$data = (array)$this->getData("sender_chat", []);
		return new Chat($data);
	}

	public function getMessageId(): int
	{
		return (int)$this->getData("message_id");
	}

	public function getAuthorSignature(): string
	{
		return (string)$this->getData("author_signature", "");
	}

}
