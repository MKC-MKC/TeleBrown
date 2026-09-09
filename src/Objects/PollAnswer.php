<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class PollAnswer extends ResponseWrapper
{

	/**
	 * Метод возвращает идентификатор опроса.
	 *
	 * @return string
	 */
	public function getPollId(): string
	{
		return (string)$this->getData("poll_id");
	}

	/**
	 * Метод возвращает чат анонимного участника голосования при его наличии.
	 *
	 * @return Chat|null
	 */
	public function getVoterChat(): Chat|null
	{
		$data = $this->getData("voter_chat");

		return is_array($data) ? new Chat($data) : null;
	}

	/**
	 * Метод возвращает чат анонимного участника голосования при его наличии.
	 *
	 * @return Chat|null
	 */
	public function getChat(): Chat|null
	{
		return $this->getVoterChat();
	}

	/**
	 * Метод возвращает пользователя, изменившего ответ, при его наличии.
	 *
	 * @return User|null
	 */
	public function getUser(): User|null
	{
		$data = $this->getData("user");

		return is_array($data) ? new User($data) : null;
	}

	/**
	 * Метод возвращает индексы выбранных вариантов.
	 *
	 * @return int[]
	 */
	public function getOptionIds(): array
	{
		return array_map(static fn(mixed $value): int => (int)$value, (array)$this->getData("option_ids", []));
	}

	/**
	 * Метод возвращает постоянные идентификаторы выбранных вариантов.
	 *
	 * @return string[]
	 */
	public function getOptionPersistentIds(): array
	{
		return array_map(static fn(mixed $value): string => (string)$value, (array)$this->getData("option_persistent_ids", []));
	}

}
