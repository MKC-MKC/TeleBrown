<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class UserProfilePhotos extends ResponseWrapper
{

	/**
	 * Общее количество фотографий профиля пользователя.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#userprofilephotos
	 */
	public function getTotalCount(): int
	{
		return (int)$this->getData("total_count");
	}

	/**
	 * Запрошенные фотографии профиля, до четырёх размеров каждой фотографии.
	 *
	 * @return PhotoSize[][]
	 * @see https://core.telegram.org/bots/api#userprofilephotos
	 */
	public function getPhotos(): array
	{
		return array_map(static fn(array $sizes): array => array_map(static fn(array $photo): PhotoSize => new PhotoSize($photo), $sizes), (array)$this->getData("photos", []));
	}

}
