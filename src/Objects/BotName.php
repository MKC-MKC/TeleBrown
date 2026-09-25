<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class BotName extends ResponseWrapper
{

	/**
	 * Имя бота.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#botname
	 */
	public function getName(): string
	{
		return (string)$this->getData("name");
	}

}
