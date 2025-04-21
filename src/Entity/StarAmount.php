<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * StarAmount – Describes an amount of Telegram Stars.
 * @see https://core.telegram.org/bots/api#staramount
 */
class StarAmount
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

	public function getAmount(): int
	{
		return (int)$this->getAsArray()["amount"] ?? 0;
	}

	public function getNanoStarAmount(): int
	{
		return (int)$this->getAsArray()["nanostar_amount"] ?? 0;
	}

}
