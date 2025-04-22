<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown;

abstract class Type
{

	abstract public function getAsArray();

	/**
	 * Извлечение и фильтрация данных.
	 *
	 * @param string $key
	 * @return mixed
	 */
	protected function getData(string $key): mixed
	{
		$data = $this->getAsArray();
		return array_key_exists($key, $data) ? $data[$key] : null;
	}

}
