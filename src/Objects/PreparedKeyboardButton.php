<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class PreparedKeyboardButton extends ResponseWrapper
{

	/**
	 * Уникальный идентификатор кнопки клавиатуры.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#preparedkeyboardbutton
	 */
	public function getId(): string
	{
		return (string)$this->getData("id");
	}

}
