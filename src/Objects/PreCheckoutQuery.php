<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class PreCheckoutQuery extends ResponseWrapper
{

	/**
	 * Уникальный идентификатор запроса.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#precheckoutquery
	 */
	public function getId(): string
	{
		return (string)$this->getData("id");
	}

	/**
	 * Пользователь, отправивший запрос.
	 *
	 * @return User
	 * @see https://core.telegram.org/bots/api#precheckoutquery
	 */
	public function getFrom(): User
	{
		$data = $this->getData("from");
		return new User($data);
	}

	/**
	 * Трёхбуквенный код валюты ISO 4217 или XTR для оплаты в Telegram Stars.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#precheckoutquery
	 */
	public function getCurrency(): string
	{
		return (string)$this->getData("currency");
	}

	/**
	 * Общая цена в минимальных единицах валюты, например 145 для 1,45 USD.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#precheckoutquery
	 */
	public function getTotalAmount(): int
	{
		return (int)$this->getData("total_amount");
	}

	/**
	 * Указанные ботом данные счёта.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#precheckoutquery
	 */
	public function getInvoicePayload(): string
	{
		return (string)$this->getData("invoice_payload");
	}

	/**
	 * Необязательно. Идентификатор выбранного варианта доставки.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#precheckoutquery
	 */
	public function getShippingOptionId(): string|null
	{
		return $this->getData("shipping_option_id");
	}

	/**
	 * Необязательно. Сведения о заказе, предоставленные пользователем.
	 *
	 * @return OrderInfo|null
	 * @see https://core.telegram.org/bots/api#precheckoutquery
	 */
	public function getOrderInfo(): OrderInfo|null
	{
		$data = $this->getData("order_info");
		return $data === null ? null : new OrderInfo($data);
	}

}
