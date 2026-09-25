<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class BotShortDescription extends ResponseWrapper
{

	/**
	 * Краткое описание бота.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#botshortdescription
	 */
	public function getShortDescription(): string
	{
		return (string)$this->getData("short_description");
	}

}
