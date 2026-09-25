<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class KeyboardButtonRequestManagedBot extends ResponseWrapper
{

	/**
	 * Знаковый 32-битный идентификатор запроса, уникальный в пределах сообщения.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#keyboardbuttonrequestmanagedbot
	 */
	public function getRequestId(): int
	{
		return (int)$this->getData("request_id");
	}

	/**
	 * Необязательно. Предлагаемое имя бота.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#keyboardbuttonrequestmanagedbot
	 */
	public function getSuggestedName(): string|null
	{
		return $this->getData("suggested_name");
	}

	/**
	 * Необязательно. Предлагаемое имя пользователя бота.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#keyboardbuttonrequestmanagedbot
	 */
	public function getSuggestedUsername(): string|null
	{
		return $this->getData("suggested_username");
	}

}
