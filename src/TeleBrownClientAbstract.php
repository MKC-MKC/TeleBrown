<?php

namespace Haikiri\TeleBrown;

abstract class TeleBrownClientAbstract
{
	public static bool $debug = false;

	/**
	 * Метод возвращает объект обновления.
	 *
	 * @return Entity\Update
	 */
	public function getUpdate(): Entity\Update
	{
		return new Entity\Update(response: $this->getUpdates());
	}

	/**
	 * Метод возвращает данные из входящего запроса.
	 *
	 * @return array
	 */
	public function getUpdates(): array
	{
		$response = $this->getResponse();
		if (empty($response)) return [];

		$result = json_decode($response, true);
		return $result ?? [];
	}

}
