<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity\MessageOrigin;

use Haikiri\TeleBrown\Entity\Chat;
use Haikiri\TeleBrown\Entity\MessageOrigin;

/**
 * MessageOriginChannel – The message was originally sent to a channel chat.
 * @see https://core.telegram.org/bots/api#messageoriginchannel
 */
class MessageOriginChannel extends MessageOrigin
{
	protected static string $type = "channel";

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

	public function getSenderUser(): Chat
	{
		return new Chat($this->getData("sender_chat"));
	}

	public function getMessageId(): int
	{
		return (int)$this->getData("message_id") ?? 0;
	}

	public function getAuthorSignature(): string
	{
		return (string)$this->getData("author_signature") ?? "";
	}

}
