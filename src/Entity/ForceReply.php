<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * ForceReply – Upon receiving a message with this object, Telegram clients will display a reply interface to the user
 * (act as if the user has selected the bot's message and tapped 'Reply').
 * This can be extremely useful if you want to create user-friendly step-by-step interfaces without having to sacrifice privacy mode.
 * Not supported in channels and for messages sent on behalf of a Telegram Business account.
 * @see https://core.telegram.org/bots/api#forcereply
 */
class ForceReply extends Type
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	public function isForceReply(): bool
	{
		return (bool)$this->getData("force_reply") ?? false;
	}

	public function getInputFieldPlaceholder(): ?string
	{
		return (string)$this->getData("input_field_placeholder") ?? null;
	}

	public function isSelective(): ?bool
	{
		return $this->getData("selective") ?? null;
	}

}
