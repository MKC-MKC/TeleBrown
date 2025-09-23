<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * PaidMediaInfo – Describes the paid media added to a message.
 * @see https://core.telegram.org/bots/api#paidmediainfo
 */
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
		$data = $this->getData("paid_media");
		return array_map(fn(array $item): PaidMedia => new PaidMedia($item), $data);
	}

}
