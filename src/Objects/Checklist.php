<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class Checklist extends ResponseWrapper
{

	/**
	 * Название списка задач.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#checklist
	 */
	public function getTitle(): string
	{
		return (string)$this->getData("title");
	}

	/**
	 * Необязательно. Специальные сущности в названии списка.
	 *
	 * @return MessageEntity[]
	 * @see https://core.telegram.org/bots/api#checklist
	 */
	public function getTitleEntities(): array
	{
		return array_map(static fn(array $item): MessageEntity => new MessageEntity($item), (array)$this->getData("title_entities", []));
	}

	/**
	 * Задачи в списке.
	 *
	 * @return ChecklistTask[]
	 * @see https://core.telegram.org/bots/api#checklist
	 */
	public function getTasks(): array
	{
		return array_map(static fn(array $item): ChecklistTask => new ChecklistTask($item), (array)$this->getData("tasks", []));
	}

	/**
	 * Необязательно. True, если пользователи, кроме создателя списка, могут добавлять задачи.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#checklist
	 */
	public function isOthersCanAddTasks(): bool
	{
		return (bool)$this->getData("others_can_add_tasks");
	}

	/**
	 * Необязательно. True, если пользователи, кроме создателя списка, могут отмечать задачи выполненными или невыполненными.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#checklist
	 */
	public function isOthersCanMarkTasksAsDone(): bool
	{
		return (bool)$this->getData("others_can_mark_tasks_as_done");
	}

}
