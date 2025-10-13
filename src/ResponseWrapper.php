<?php

namespace Haikiri\TeleBrown;

abstract class ResponseWrapper
{

	public function __construct(private readonly array|null $response)
	{
	}

	public function getAsArray(): array|null
	{
		return $this->response;
	}

	/**
	 * Извлечение и фильтрация данных.
	 * @param string|null $key
	 * @param mixed|null $default
	 * @return mixed
	 */
	public function getData(string|null $key = null, mixed $default = null): mixed
	{
		$data = $this->getAsArray();
		if ($key === null) return $data;

		foreach (explode(".", $key) as $segment) {
			if (!is_array($data) || !array_key_exists($segment, $data)) {
				return $default;
			}
			$data = $data[$segment];
		}

		return $data;
	}

}
