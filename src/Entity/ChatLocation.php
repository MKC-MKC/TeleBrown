<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * ChatLocation – Represents a location to which a chat is connected.
 * @see https://core.telegram.org/bots/api#chatlocation
 */
class ChatLocation extends Type
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	public function getLocation(): Location
	{
		return new Location($this->getData("location"));
	}

	public function getAddress(): string
	{
		return (string)$this->getData("address") ?? "";
	}

}
