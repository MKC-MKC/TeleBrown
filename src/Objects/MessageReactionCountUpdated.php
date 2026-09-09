<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class MessageReactionCountUpdated extends ResponseWrapper
{

	/**
	 * Метод возвращает чат с сообщением.
	 *
	 * @return Chat
	 */
	public function getChat(): Chat
	{
		return new Chat((array)$this->getData("chat", []));
	}

	/**
	 * Метод возвращает идентификатор сообщения.
	 *
	 * @return int
	 */
	public function getMessageId(): int
	{
		return (int)$this->getData("message_id");
	}

	/**
	 * Метод возвращает время изменения счётчиков в Unix-формате.
	 *
	 * @return int
	 */
	public function getDate(): int
	{
		return (int)$this->getData("date");
	}

	/**
	 * Метод возвращает счётчики реакций на сообщение.
	 *
	 * @return ReactionCount[]
	 */
	public function getReactions(): array
	{
		return array_map(
			static fn(array $item): ReactionCount => new ReactionCount($item),
			(array)$this->getData("reactions", []),
		);
	}

}
