<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class OrderInfo extends ResponseWrapper
{

	/**
	 * Необязательно. Имя пользователя.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#orderinfo
	 */
	public function getName(): string|null
	{
		return $this->getData("name");
	}

	/**
	 * Необязательно. Телефон пользователя.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#orderinfo
	 */
	public function getPhoneNumber(): string|null
	{
		return $this->getData("phone_number");
	}

	/**
	 * Необязательно. Электронная почта пользователя.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#orderinfo
	 */
	public function getEmail(): string|null
	{
		return $this->getData("email");
	}

	/**
	 * Необязательно. Адрес доставки пользователя.
	 *
	 * @return ShippingAddress|null
	 * @see https://core.telegram.org/bots/api#orderinfo
	 */
	public function getShippingAddress(): ShippingAddress|null
	{
		$data = $this->getData("shipping_address");
		return $data === null ? null : new ShippingAddress($data);
	}

}
