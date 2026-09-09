<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class ChatBoost extends ResponseWrapper
{

	/**
	 * Метод возвращает идентификатор boost.
	 *
	 * @return string
	 */
	public function getBoostId(): string
	{
		return (string)$this->getData("boost_id");
	}

	/**
	 * Метод возвращает время добавления boost в Unix-формате.
	 *
	 * @return int
	 */
	public function getAddDate(): int
	{
		return (int)$this->getData("add_date");
	}

	/**
	 * Метод возвращает время истечения boost в Unix-формате.
	 *
	 * @return int
	 */
	public function getExpirationDate(): int
	{
		return (int)$this->getData("expiration_date");
	}

	/**
	 * Метод возвращает источник boost.
	 *
	 * @return ChatBoostSource
	 */
	public function getSource(): ChatBoostSource
	{
		return new ChatBoostSource((array)$this->getData("source", []));
	}

}
