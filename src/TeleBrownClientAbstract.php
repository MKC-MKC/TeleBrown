<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown;

abstract class TeleBrownClientAbstract
{
	public static bool $debug = false;
	public array $response = [];

	/**
	 * Записываем ответ сервера.
	 *
	 * @return void
	 */
	abstract public function setUpdates(): void;

	/**
	 * Метод возвращает данные из входящего запроса.
	 *
	 * @return array
	 */
	public function getUpdates(): array
	{
		return $this->response ?? [];
	}

	/**
	 * Метод возвращает объект обновления.
	 *
	 * @return Entity\Update
	 */
	public function getUpdate(): Entity\Update
	{
		return new Entity\Update(response: $this->getUpdates());
	}

}
