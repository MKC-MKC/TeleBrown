<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * ChatLocation – Represents a location to which a chat is connected.
 * @see https://core.telegram.org/bots/api#chatlocation
 */
class ChatLocation
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

	public function getLocation(): Location
	{
		return new Location($this->getAsArray()["location"] ?? []);
	}

	public function getAddress(): string
	{
		return (string)$this->getAsArray()["address"] ?? "";
	}

}
