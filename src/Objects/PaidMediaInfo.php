<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class PaidMediaInfo extends ResponseWrapper
{

	/**
	 * The number of Telegram Stars that must be paid to buy access to the media
	 * @return int
	 */
	public function getStarCount(): int
	{
		return (int)$this->getData("star_count");
	}

	/**
	 * Information about the paid media
	 * @return PaidMedia[]
	 * @deprecated todo
	 */
	public function getPaidMedia(): array
	{
		return array_map(fn(array $item): PaidMedia => new PaidMedia($item), $this->getData());
	}

}
