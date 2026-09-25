<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class BotDescription extends ResponseWrapper
{

	/**
	 * Описание бота.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#botdescription
	 */
	public function getDescription(): string
	{
		return (string)$this->getData("description");
	}

}
