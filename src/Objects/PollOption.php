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
		$data = $this->getData("text_entities");
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

}
