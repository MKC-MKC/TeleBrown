<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown;

abstract class Type
{
	protected array|null $response = null;

	abstract public function getAsArray();

	/**
	 * Извлечение и фильтрация данных.
	 *
	 * @param string $key
	 * @return mixed
	 */
	protected function getData(string $key): mixed
	{
		$data = $this->response;
		return array_key_exists($key, $data) ? $data[$key] : null;
	}

}
