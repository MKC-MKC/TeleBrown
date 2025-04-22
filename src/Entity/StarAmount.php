<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * StarAmount – Describes an amount of Telegram Stars.
 * @see https://core.telegram.org/bots/api#staramount
 */
class StarAmount extends Type
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	public function getAmount(): int
	{
		return (int)$this->getData("amount") ?? 0;
	}

	public function getNanoStarAmount(): int
	{
		return (int)$this->getData("nanostar_amount") ?? 0;
	}

}
