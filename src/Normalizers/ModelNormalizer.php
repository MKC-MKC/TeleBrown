<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Normalizers;

use Haikiri\TeleBrown\ResponseWrapper;

class ModelNormalizer
{

	/**
	 * Преобразуем вложенные модели Telegram в массивы, сохраняя ключи и значения полей.
	 *
	 * @param array $data Данные модели или параметры запроса, например ["entities" => [$entity]].
	 * @return array Данные с массивами вместо объектов ResponseWrapper.
	 */
	public static function normalize(array $data): array
	{
		return array_map(static fn($value) => match (true) {
			$value instanceof ResponseWrapper => $value->getAsArray(),
			is_array($value) => self::normalize($value),
			default => $value,
		}, $data);
	}

}
