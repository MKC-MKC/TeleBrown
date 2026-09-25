<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class PreparedInlineMessage extends ResponseWrapper
{

	/**
	 * Уникальный идентификатор подготовленного сообщения.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#preparedinlinemessage
	 */
	public function getId(): string
	{
		return (string)$this->getData("id");
	}

	/**
	 * Срок действия сообщения в формате Unix. Сообщение с истёкшим сроком больше нельзя использовать.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#preparedinlinemessage
	 */
	public function getExpirationDate(): int
	{
		return (int)$this->getData("expiration_date");
	}

}
