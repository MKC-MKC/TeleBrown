<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class ChatBoostRemoved extends ResponseWrapper
{

	/**
	 * Метод возвращает чат, из которого удалён boost.
	 *
	 * @return Chat
	 */
	public function getChat(): Chat
	{
		return new Chat((array)$this->getData("chat", []));
	}

	/**
	 * Метод возвращает идентификатор удалённого boost.
	 *
	 * @return string
	 */
	public function getBoostId(): string
	{
		return (string)$this->getData("boost_id");
	}

	/**
	 * Метод возвращает время удаления boost в Unix-формате.
	 *
	 * @return int
	 */
	public function getRemoveDate(): int
	{
		return (int)$this->getData("remove_date");
	}

	/**
	 * Метод возвращает время события в Unix-формате.
	 *
	 * @return int
	 */
	public function getDate(): int
	{
		return $this->getRemoveDate();
	}

	/**
	 * Метод возвращает источник удалённого boost.
	 *
	 * @return ChatBoostSource
	 */
	public function getSource(): ChatBoostSource
	{
		return new ChatBoostSource((array)$this->getData("source", []));
	}

	/**
	 * Метод возвращает связанного с boost пользователя при его наличии.
	 *
	 * @return User|null
	 */
	public function getUser(): User|null
	{
		return $this->getSource()->getUser();
	}

}
