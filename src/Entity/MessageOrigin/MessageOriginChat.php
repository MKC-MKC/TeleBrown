<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity\MessageOrigin;

use Haikiri\TeleBrown\Entity\Chat;
use Haikiri\TeleBrown\Entity\MessageOrigin;

/**
 * MessageOriginChat – The message was originally sent on behalf of a chat to a group chat.
 * @see https://core.telegram.org/bots/api#messageoriginchat
 */
class MessageOriginChat extends MessageOrigin
{
	protected static string $type = "chat";
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

	public function getSenderUser(): Chat
	{
		return new Chat($this->getAsArray()["sender_chat"] ?? []);
	}

	public function getAuthorSignature(): string
	{
		return (string)$this->getAsArray()["author_signature"] ?? "";
	}

}
