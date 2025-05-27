<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects\MessageOrigin;

use Haikiri\TeleBrown\Objects\Chat;
use Haikiri\TeleBrown\Objects\MessageOrigin;

/**
 * MessageOriginChat – The message was originally sent on behalf of a chat to a group chat.
 * @see https://core.telegram.org/bots/api#messageoriginchat
 */
class MessageOriginChat extends MessageOrigin
{
	protected static string $type = "chat";

	public static function getType(): string
	{
		return self::$type;
	}

	public function getDate(): int
	{
		return (int)$this->getData("date");
	}

	public function getSenderChat(): Chat
	{
		$data = (array)$this->getData("sender_chat", []);
		return new Chat($data);
	}

	public function getAuthorSignature(): string
	{
		return (string)$this->getData("author_signature", "");
	}

}
