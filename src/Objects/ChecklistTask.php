<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class ChecklistTask extends ResponseWrapper
{

	/**
	 * Уникальный идентификатор задачи.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#checklisttask
	 */
	public function getId(): int
	{
		return (int)$this->getData("id");
	}

	/**
	 * Текст задачи.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#checklisttask
	 */
	public function getText(): string
	{
		return (string)$this->getData("text");
	}

	/**
	 * Необязательно. Специальные сущности в тексте задачи.
	 *
	 * @return MessageEntity[]
	 * @see https://core.telegram.org/bots/api#checklisttask
	 */
	public function getTextEntities(): array
	{
		return array_map(static fn(array $item): MessageEntity => new MessageEntity($item), (array)$this->getData("text_entities", []));
	}

	/**
	 * Необязательно. Пользователь, выполнивший задачу; отсутствует, если задача не выполнена пользователем.
	 *
	 * @return User|null
	 * @see https://core.telegram.org/bots/api#checklisttask
	 */
	public function getCompletedByUser(): User|null
	{
		$data = $this->getData("completed_by_user");
		return $data === null ? null : new User($data);
	}

	/**
	 * Необязательно. Чат, выполнивший задачу; отсутствует, если задача не выполнена чатом.
	 *
	 * @return Chat|null
	 * @see https://core.telegram.org/bots/api#checklisttask
	 */
	public function getCompletedByChat(): Chat|null
	{
		$data = $this->getData("completed_by_chat");
		return $data === null ? null : new Chat($data);
	}

	/**
	 * Необязательно. Время выполнения задачи в Unix-формате; 0, если задача не выполнена.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#checklisttask
	 */
	public function getCompletionDate(): int|null
	{
		return $this->getData("completion_date");
	}

}
