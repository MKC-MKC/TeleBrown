<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * ChatLocation – Represents a location to which a chat is connected.
 * @see https://core.telegram.org/bots/api#chatlocation
 */
class ChatLocation extends ResponseWrapper
{

	public function getLocation(): Location
	{
		$data = (array)$this->getData("location", []);
		return new Location($data);
	}

	public function getAddress(): string
	{
		return (string)$this->getData("address");
	}

}
