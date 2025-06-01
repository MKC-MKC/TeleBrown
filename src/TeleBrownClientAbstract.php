<?php

namespace Haikiri\TeleBrown;

abstract class TeleBrownClientAbstract
{

	public array $response = [];
	protected static bool $debug;

	public function __construct($debug = false)
	{
		self::$debug = filter_var($debug, FILTER_VALIDATE_BOOLEAN);
	}

	/**
	 * Записываем ответ сервера.
	 * @return void
	 */
	abstract public function setUpdates(): void;

	/**
	 * Метод возвращает данные из входящего запроса.
	 * @return array
	 */
	public function getUpdates(): array
	{
		return $this->response ?? [];
	}

	/**
	 * Метод возвращает объект обновления.
	 * @return Objects\Update
	 */
	public function getUpdate(): object
	{
		return new Objects\Update(response: $this->getUpdates());
	}

}
