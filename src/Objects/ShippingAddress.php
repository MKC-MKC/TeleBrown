<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class ShippingAddress extends ResponseWrapper
{

	/**
	 * Двухбуквенный код страны ISO 3166-1 alpha-2.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#shippingaddress
	 */
	public function getCountryCode(): string
	{
		return (string)$this->getData("country_code");
	}

	/**
	 * Регион, если применимо.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#shippingaddress
	 */
	public function getState(): string
	{
		return (string)$this->getData("state");
	}

	/**
	 * Город.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#shippingaddress
	 */
	public function getCity(): string
	{
		return (string)$this->getData("city");
	}

	/**
	 * Первая строка адреса.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#shippingaddress
	 */
	public function getStreetLine1(): string
	{
		return (string)$this->getData("street_line1");
	}

	/**
	 * Вторая строка адреса.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#shippingaddress
	 */
	public function getStreetLine2(): string
	{
		return (string)$this->getData("street_line2");
	}

	/**
	 * Почтовый индекс.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#shippingaddress
	 */
	public function getPostCode(): string
	{
		return (string)$this->getData("post_code");
	}

}
