<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class InputChecklistTask extends ResponseWrapper
{

	/**
	 * Положительный идентификатор задачи, уникальный среди задач этого списка.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#inputchecklisttask
	 */
	public function getId(): int
	{
		return (int)$this->getData("id");
	}

	/**
	 * Текст задачи, 1-100 символов после разбора сущностей.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#inputchecklisttask
	 */
	public function getText(): string
	{
		return (string)$this->getData("text");
	}

	/**
	 * Необязательно. Режим разбора сущностей в тексте.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputchecklisttask
	 */
	public function getParseMode(): string|null
	{
		return $this->getData("parse_mode");
	}

	/**
	 * Необязательно. Сущности текста, которые можно указать вместо режима разбора. Допускаются bold, italic, underline, strikethrough, spoiler, custom_emoji и date_time.
	 *
	 * @return MessageEntity[]
	 * @see https://core.telegram.org/bots/api#inputchecklisttask
	 */
	public function getTextEntities(): array
	{
		return array_map(static fn(array $item): MessageEntity => new MessageEntity($item), $this->getData("text_entities", []));
	}

}
