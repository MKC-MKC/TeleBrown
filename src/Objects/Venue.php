<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class Venue extends ResponseWrapper
{

	/**
	 * Местоположение заведения; не может быть трансляцией геопозиции.
	 *
	 * @return Location
	 * @see https://core.telegram.org/bots/api#venue
	 */
	public function getLocation(): Location
	{
		$data = $this->getData("location");
		return new Location($data);
	}

	/**
	 * Название заведения.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#venue
	 */
	public function getTitle(): string
	{
		return (string)$this->getData("title");
	}

	/**
	 * Адрес заведения.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#venue
	 */
	public function getAddress(): string
	{
		return (string)$this->getData("address");
	}

	/**
	 * Необязательно. Идентификатор заведения в Foursquare.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#venue
	 */
	public function getFoursquareId(): string|null
	{
		return $this->getData("foursquare_id");
	}

	/**
	 * Необязательно. Тип заведения в Foursquare, например food/icecream.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#venue
	 */
	public function getFoursquareType(): string|null
	{
		return $this->getData("foursquare_type");
	}

	/**
	 * Необязательно. Идентификатор заведения в Google Places.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#venue
	 */
	public function getGooglePlaceId(): string|null
	{
		return $this->getData("google_place_id");
	}

	/**
	 * Необязательно. Тип заведения в Google Places.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#venue
	 */
	public function getGooglePlaceType(): string|null
	{
		return $this->getData("google_place_type");
	}

}
