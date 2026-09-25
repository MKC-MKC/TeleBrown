<?php

namespace Haikiri\TeleBrown;

abstract class TeleBrownClientAbstract
{

	protected static bool $debug;
	protected array $response = [];

	public function __construct($debug = false)
	{
		self::$debug = filter_var($debug, FILTER_VALIDATE_BOOLEAN);
	}

	/**
	 * Записываем ответ сервера.
	 * @param array $update
	 * @return void
	 */
	abstract public function setUpdates(array $update): void;

	/**
	 * Метод возвращает объект обновления.
	 * @return Objects\Update
	 */
	public function getUpdate(): object
	{
		return new Objects\Update(response: $this->getUpdates());
	}

	/**
	 * Метод возвращает данные из входящего запроса.
	 * @return array
	 */
	public function getUpdates(): array
	{
		return $this->response ?? [];
	}

}
