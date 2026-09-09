<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class MessageReactionUpdated extends ResponseWrapper
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
	 * Метод возвращает пользователя, изменившего реакцию, при его наличии.
	 *
	 * @return User|null
	 */
	public function getUser(): User|null
	{
		$data = $this->getData("user");

		return is_array($data) ? new User($data) : null;
	}

	/**
	 * Метод возвращает чат, от имени которого изменена реакция, при его наличии.
	 *
	 * @return Chat|null
	 */
	public function getActorChat(): Chat|null
	{
		$data = $this->getData("actor_chat");

		return is_array($data) ? new Chat($data) : null;
	}

	/**
	 * Метод возвращает время изменения реакции в Unix-формате.
	 *
	 * @return int
	 */
	public function getDate(): int
	{
		return (int)$this->getData("date");
	}

	/**
	 * Метод возвращает прежний набор реакций.
	 *
	 * @return ReactionType[]
	 */
	public function getOldReaction(): array
	{
		return array_map(
			static fn(array $item): ReactionType => new ReactionType($item),
			(array)$this->getData("old_reaction", []),
		);
	}

	/**
	 * Метод возвращает новый набор реакций.
	 *
	 * @return ReactionType[]
	 */
	public function getNewReaction(): array
	{
		return array_map(
			static fn(array $item): ReactionType => new ReactionType($item),
			(array)$this->getData("new_reaction", []),
		);
	}

}
