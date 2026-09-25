<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * Poll – This object contains information about a poll.
 * @see https://core.telegram.org/bots/api#poll
 */
class Poll extends ResponseWrapper
{

	/**
	 * Уникальный идентификатор опроса
	 * Unique poll identifier
	 *
	 * @return string
	 */
	public function getId(): string
	{
		return (string)$this->getData("id");
	}

	/**
	 * Вопрос опроса, 1-300 символов
	 * Poll question, 1-300 characters
	 *
	 * @return string
	 */
	public function getQuestion(): string
	{
		return (string)$this->getData("question");
	}

	/**
	 * Опционально. Специальные сущности, которые появляются в вопросе.
	 * В настоящее время в вопросах опроса разрешены только пользовательские сущности emoji.
	 *
	 * Optional. Special entities that appear in the question.
	 * Currently, only custom emoji entities are allowed in poll questions
	 *
	 * @return MessageEntity[]
	 */
	public function getQuestionEntities(): array
	{
		$data = (array)$this->getData("question_entities", []);
		return array_map(fn(array $item): MessageEntity => new MessageEntity($item), $data);
	}

	/**
	 * Список вариантов опроса
	 * List of poll options
	 *
	 * @return PollOption[]
	 */
	public function getOptions(): array
	{
		$data = $this->getData("options");
		return array_map(fn(array $item): PollOption => new PollOption($item), $data);
	}

	/**
	 * Общее количество пользователей, проголосовавших в опросе
	 * Total number of users that voted in the poll
	 *
	 * @return int
	 */
	public function getTotalVoterCount(): int
	{
		return (int)$this->getData("total_voter_count");
	}

	/**
	 * True, если опрос закрыт
	 * True, if the poll is closed
	 *
	 * @return bool
	 */
	public function isClosed(): bool
	{
		return (bool)$this->getData("is_closed");
	}

	/**
	 * True, если опрос анонимен
	 * True, if the poll is anonymous
	 *
	 * @return bool
	 */
	public function isAnonymous(): bool
	{
		return (bool)$this->getData("is_anonymous");
	}

	/**
	 * Тип опроса, в настоящее время может быть «regular» или «quiz»
	 * Poll type, currently can be “regular” or “quiz”
	 *
	 * @return string
	 */
	public function getType(): string
	{
		return (string)$this->getData("type");
	}

	/**
	 * True, если опрос позволяет несколько ответов
	 * True, if the poll allows multiple answers
	 *
	 * @return bool
	 */
	public function getAllowsMultipleAnswers(): bool
	{
		return (bool)$this->getData("allows_multiple_answers");
	}


	/**
	 * Текст, который отображается, когда пользователь выбирает неправильный ответ
	 * или нажимает на значок лампы в опросе в стиле викторины, 0-200 символов
	 *
	 * Text that is shown when a user chooses an incorrect answer
	 * or taps on the lamp icon in a quiz-style poll, 0-200 characters
	 *
	 * @return string
	 */
	public function getExplanation(): string
	{
		return (string)$this->getData("explanation");
	}

	/**
	 * Опционально. Специальные сущности, такие как имена пользователей, URL-адреса, команды ботов и т. д., которые появляются в объяснении
	 * Optional. Special entities like usernames, URLs, bot commands, etc. that appear in the explanation
	 *
	 * @return MessageEntity[]
	 */
	public function getExplanationEntities(): array
	{
		$data = (array)$this->getData("explanation_entities", []);
		return array_map(fn(array $item): MessageEntity => new MessageEntity($item), $data);
	}

	/**
	 * Опционально. Время в секундах, в течение которого опрос будет активен после создания
	 * Optional. Amount of time in seconds the poll will be active after creation
	 *
	 * @return int
	 */
	public function getOpenPeriod(): int
	{
		return (int)$this->getData("open_period");
	}

	/**
	 * Опционально. Момент времени (Unix-временная метка), когда опрос будет автоматически закрыт
	 * Optional. Point in time (Unix timestamp) when the poll will be automatically closed
	 *
	 * @return int
	 */
	public function getCloseDate(): int
	{
		return (int)$this->getData("close_date");
	}

	/**
	 * True, если опрос разрешает менять выбранные варианты ответа.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#poll
	 */
	public function allowsRevoting(): bool
	{
		return (bool)$this->getData("allows_revoting");
	}

	/**
	 * True, если голосовать могут только пользователи, состоящие в исходном чате более 24 часов.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#poll
	 */
	public function isMembersOnly(): bool
	{
		return (bool)$this->getData("members_only");
	}

	/**
	 * Необязательно. Двухбуквенные коды стран ISO 3166-1 alpha-2, из которых разрешено голосовать; FT обозначает анонимные номера.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#poll
	 */
	public function getCountryCodes(): array
	{
		return (array)$this->getData("country_codes", []);
	}

	/**
	 * Необязательно. Идентификаторы правильных вариантов ответа, начиная с нуля; доступны для викторин, закрытых или отправленных ботом либо в личный чат с ботом.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#poll
	 */
	public function getCorrectOptionIds(): array
	{
		return (array)$this->getData("correct_option_ids", []);
	}

	/**
	 * Необязательно. Описание опроса; только для опросов внутри объекта Message.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#poll
	 */
	public function getDescription(): string|null
	{
		return $this->getData("description");
	}

	/**
	 * Необязательно. Специальные сущности в описании опроса.
	 *
	 * @return MessageEntity[]
	 * @see https://core.telegram.org/bots/api#poll
	 */
	public function getDescriptionEntities(): array
	{
		return array_map(static fn(array $item): MessageEntity => new MessageEntity($item), (array)$this->getData("description_entities", []));
	}

	/**
	 * Необязательно. Медиа в описании опроса; только для опросов внутри объекта Message.
	 *
	 * @return PollMedia|null
	 * @see https://core.telegram.org/bots/api#poll
	 */
	public function getMedia(): PollMedia|null
	{
		$data = $this->getData("media");
		return $data === null ? null : new PollMedia($data);
	}

	/**
	 * Необязательно. Медиа, добавленное к объяснению викторины.
	 *
	 * @return PollMedia|null
	 * @see https://core.telegram.org/bots/api#poll
	 */
	public function getExplanationMedia(): PollMedia|null
	{
		$data = $this->getData("explanation_media");
		return $data === null ? null : new PollMedia($data);
	}

}
