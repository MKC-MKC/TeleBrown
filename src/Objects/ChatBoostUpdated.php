<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class ChatBoostUpdated extends ResponseWrapper
{

	/**
	 * Метод возвращает усиленный чат.
	 *
	 * @return Chat
	 */
	public function getChat(): Chat
	{
		return new Chat((array)$this->getData("chat", []));
	}

	/**
	 * Метод возвращает сведения о boost.
	 *
	 * @return ChatBoost
	 */
	public function getBoost(): ChatBoost
	{
		return new ChatBoost((array)$this->getData("boost", []));
	}

	/**
	 * Метод возвращает время добавления boost в Unix-формате.
	 *
	 * @return int
	 */
	public function getDate(): int
	{
		return $this->getBoost()->getAddDate();
	}

	/**
	 * Метод возвращает связанного с boost пользователя при его наличии.
	 *
	 * @return User|null
	 */
	public function getUser(): User|null
	{
		return $this->getBoost()->getSource()->getUser();
	}

}
