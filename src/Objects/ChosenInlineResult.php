<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class ChosenInlineResult extends ResponseWrapper
{

	/**
	 * Уникальный идентификатор выбранного результата.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#choseninlineresult
	 */
	public function getResultId(): string
	{
		return (string)$this->getData("result_id");
	}

	/**
	 * Пользователь, выбравший результат.
	 *
	 * @return User
	 * @see https://core.telegram.org/bots/api#choseninlineresult
	 */
	public function getFrom(): User
	{
		$data = $this->getData("from");
		return new User($data);
	}

	/**
	 * Необязательно. Местоположение отправителя; только для ботов, запрашивающих геопозицию.
	 *
	 * @return Location|null
	 * @see https://core.telegram.org/bots/api#choseninlineresult
	 */
	public function getLocation(): Location|null
	{
		$data = $this->getData("location");
		return $data === null ? null : new Location($data);
	}

	/**
	 * Необязательно. Идентификатор отправленного inline-сообщения; доступен, если к сообщению прикреплена inline-клавиатура.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#choseninlineresult
	 */
	public function getInlineMessageId(): string|null
	{
		return $this->getData("inline_message_id");
	}

	/**
	 * Запрос, по которому получен результат.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#choseninlineresult
	 */
	public function getQuery(): string
	{
		return (string)$this->getData("query");
	}

}
