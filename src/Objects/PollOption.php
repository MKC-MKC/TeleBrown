<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * PollOption – This object contains information about one answer option in a poll.
 * @see https://core.telegram.org/bots/api#polloption
 */
class PollOption extends ResponseWrapper
{

	/**
	 * Текст варианта ответа, 1-100 символов
	 * Option text, 1-100 characters
	 *
	 * @return string
	 */
	public function getText(): string
	{
		return (string)$this->getData("text");
	}

	/**
	 * Опционально. Специальные сущности, которые появляются в тексте варианта.
	 * В настоящее время в текстах вариантов опроса разрешены только пользовательские сущности
	 *
	 * Optional. Special entities that appear in the option text.
	 * Currently, only custom emoji entities are allowed in poll option texts
	 *
	 * @return MessageEntity[]
	 */
	public function getTextEntities(): array
	{
		$data = (array)$this->getData("text_entities", []);
		return array_map(fn(array $item): MessageEntity => new MessageEntity($item), $data);
	}

	/**
	 * Количество пользователей, проголосовавших за этот вариант
	 * Number of users that voted for this option
	 *
	 * @return int
	 */
	public function getVoterCount(): int
	{
		return (int)$this->getData("voter_count");
	}

	/**
	 * Уникальный идентификатор варианта, сохраняющийся при добавлении и удалении вариантов.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#polloption
	 */
	public function getPersistentId(): string
	{
		return (string)$this->getData("persistent_id");
	}

	/**
	 * Необязательно. Медиа, добавленное к варианту ответа.
	 *
	 * @return PollMedia|null
	 * @see https://core.telegram.org/bots/api#polloption
	 */
	public function getMedia(): PollMedia|null
	{
		$data = $this->getData("media");
		return $data === null ? null : new PollMedia($data);
	}

	/**
	 * Необязательно. Пользователь, добавивший вариант после создания опроса.
	 *
	 * @return User|null
	 * @see https://core.telegram.org/bots/api#polloption
	 */
	public function getAddedByUser(): User|null
	{
		$data = $this->getData("added_by_user");
		return $data === null ? null : new User($data);
	}

	/**
	 * Необязательно. Чат, добавивший вариант после создания опроса.
	 *
	 * @return Chat|null
	 * @see https://core.telegram.org/bots/api#polloption
	 */
	public function getAddedByChat(): Chat|null
	{
		$data = $this->getData("added_by_chat");
		return $data === null ? null : new Chat($data);
	}

	/**
	 * Необязательно. Время добавления варианта в Unix-формате; отсутствует у исходных вариантов опроса.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#polloption
	 */
	public function getAdditionDate(): int|null
	{
		return $this->getData("addition_date");
	}

}
