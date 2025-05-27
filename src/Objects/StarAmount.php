<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * StarAmount – Describes an amount of Telegram Stars.
 * @see https://core.telegram.org/bots/api#staramount
 */
class StarAmount extends ResponseWrapper
{

	public function getAmount(): int
	{
		return (int)$this->getData("amount");
	}

	public function getNanoStarAmount(): int
	{
		return (int)$this->getData("nanostar_amount");
	}

}
