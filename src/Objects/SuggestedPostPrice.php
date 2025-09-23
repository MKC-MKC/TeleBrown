<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * SuggestedPostPrice – Describes the price of a suggested post.
 * @see https://core.telegram.org/bots/api#suggestedpostprice
 */
class SuggestedPostPrice extends ResponseWrapper
{

	/**
	 * Валюта, в которой будет оплачиваться пост. В настоящее время должна быть одной из «XTR» для Telegram Stars или «TON» для toncoins
	 * Currency in which the post will be paid. Currently, must be one of “XTR” for Telegram Stars or “TON” for toncoins
	 *
	 * @return string
	 */
	public function getCurrency(): string
	{
		return (string)$this->getData("currency");
	}

	/**
	 * Сумма валюты, которая будет выплачена за пост в наименьших единицах валюты, т.е. Telegram Stars или нанотонкоины.
	 * В настоящее время цена в Telegram Stars должна быть от 5 до 100000, а цена в нанотонкоинах должна быть от 10000000 до 10000000000000.
	 *
	 * The amount of the currency that will be paid for the post in the smallest units of the currency, i.e. Telegram Stars or nanotoncoins.
	 * Currently, price in Telegram Stars must be between 5 and 100000, and price in nanotoncoins must be between 10000000 and 10000000000000.
	 *
	 * @return int
	 */
	public function getAmount(): int
	{
		return (int)$this->getData("amount");
	}

}
