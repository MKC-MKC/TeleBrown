<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class Invoice extends ResponseWrapper
{

	/**
	 * Название товара.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#invoice
	 */
	public function getTitle(): string
	{
		return (string)$this->getData("title");
	}

	/**
	 * Описание товара.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#invoice
	 */
	public function getDescription(): string
	{
		return (string)$this->getData("description");
	}

	/**
	 * Уникальный параметр ссылки на бота для создания этого счёта.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#invoice
	 */
	public function getStartParameter(): string
	{
		return (string)$this->getData("start_parameter");
	}

	/**
	 * Трёхбуквенный код валюты ISO 4217 или XTR для Telegram Stars.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#invoice
	 */
	public function getCurrency(): string
	{
		return (string)$this->getData("currency");
	}

	/**
	 * Общая цена в минимальных единицах валюты, например 145 для 1,45 USD.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#invoice
	 */
	public function getTotalAmount(): int
	{
		return (int)$this->getData("total_amount");
	}

}
