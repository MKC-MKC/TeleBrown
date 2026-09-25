<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class Dice extends ResponseWrapper
{

	/**
	 * Эмодзи, на котором основана анимация броска.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#dice
	 */
	public function getEmoji(): string
	{
		return (string)$this->getData("emoji");
	}

	/**
	 * Значение броска, диапазон зависит от выбранного эмодзи.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#dice
	 */
	public function getValue(): int
	{
		return (int)$this->getData("value");
	}

}
