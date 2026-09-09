<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class MessageGenerationStopped extends ResponseWrapper
{

	/**
	 * Метод возвращает чат, в котором остановлена генерация сообщения.
	 *
	 * @return Chat
	 */
	public function getChat(): Chat
	{
		return new Chat((array)$this->getData("chat", []));
	}

	/**
	 * Метод возвращает идентификатор темы сообщения.
	 *
	 * @return int|null
	 */
	public function getMessageThreadId(): int|null
	{
		$value = $this->getData("message_thread_id");

		return $value === null ? null : (int)$value;
	}

	/**
	 * Метод возвращает идентификатор остановленного черновика.
	 *
	 * @return int
	 */
	public function getDraftId(): int
	{
		return (int)$this->getData("draft_id");
	}

}
