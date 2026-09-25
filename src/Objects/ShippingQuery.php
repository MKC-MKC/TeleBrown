<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class ShippingQuery extends ResponseWrapper
{

	/**
	 * Уникальный идентификатор запроса.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#shippingquery
	 */
	public function getId(): string
	{
		return (string)$this->getData("id");
	}

	/**
	 * Пользователь, отправивший запрос.
	 *
	 * @return User
	 * @see https://core.telegram.org/bots/api#shippingquery
	 */
	public function getFrom(): User
	{
		$data = $this->getData("from");
		return new User($data);
	}

	/**
	 * Указанные ботом данные счёта.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#shippingquery
	 */
	public function getInvoicePayload(): string
	{
		return (string)$this->getData("invoice_payload");
	}

	/**
	 * Адрес доставки, указанный пользователем.
	 *
	 * @return ShippingAddress
	 * @see https://core.telegram.org/bots/api#shippingquery
	 */
	public function getShippingAddress(): ShippingAddress
	{
		$data = $this->getData("shipping_address");
		return new ShippingAddress($data);
	}

}
