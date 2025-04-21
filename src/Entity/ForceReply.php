<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * ForceReply – Upon receiving a message with this object, Telegram clients will display a reply interface to the user
 * (act as if the user has selected the bot's message and tapped 'Reply').
 * This can be extremely useful if you want to create user-friendly step-by-step interfaces without having to sacrifice privacy mode.
 * Not supported in channels and for messages sent on behalf of a Telegram Business account.
 * @see https://core.telegram.org/bots/api#forcereply
 */
class ForceReply
{
	private array $response;

	public function __construct(array $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array
	{
		return $this->response ?? [];
	}

	public function isForceReply(): bool
	{
		return (bool)$this->getAsArray()["force_reply"] ?? false;
	}

	public function getInputFieldPlaceholder(): ?string
	{
		return (string)$this->getAsArray()["input_field_placeholder"] ?? null;
	}

	public function isSelective(): ?bool
	{
		return $this->getAsArray()["selective"] ?? null;
	}

}
