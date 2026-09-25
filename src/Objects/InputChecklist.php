<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class InputChecklist extends ResponseWrapper
{

	/**
	 * Заголовок списка задач, 1-255 символов после разбора сущностей.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#inputchecklist
	 */
	public function getTitle(): string
	{
		return (string)$this->getData("title");
	}

	/**
	 * Необязательно. Режим разбора сущностей в тексте.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputchecklist
	 */
	public function getParseMode(): string|null
	{
		return $this->getData("parse_mode");
	}

	/**
	 * Необязательно. Сущности заголовка вместо parse_mode: bold, italic, underline, strikethrough, spoiler, custom_emoji и date_time.
	 *
	 * @return MessageEntity[]
	 * @see https://core.telegram.org/bots/api#inputchecklist
	 */
	public function getTitleEntities(): array
	{
		return array_map(static fn(array $item): MessageEntity => new MessageEntity($item), $this->getData("title_entities", []));
	}

	/**
	 * Список от 1 до 30 задач.
	 *
	 * @return InputChecklistTask[]
	 * @see https://core.telegram.org/bots/api#inputchecklist
	 */
	public function getTasks(): array
	{
		return array_map(static fn(array $item): InputChecklistTask => new InputChecklistTask($item), $this->getData("tasks", []));
	}

	/**
	 * Необязательно. True, если другие пользователи могут добавлять задачи.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#inputchecklist
	 */
	public function canOthersAddTasks(): bool
	{
		return (bool)$this->getData("others_can_add_tasks", false);
	}

	/**
	 * Необязательно. True, если другие пользователи могут отмечать задачи выполненными или невыполненными.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#inputchecklist
	 */
	public function canOthersMarkTasksAsDone(): bool
	{
		return (bool)$this->getData("others_can_mark_tasks_as_done", false);
	}

}
