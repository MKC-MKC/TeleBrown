<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class UserProfileAudios extends ResponseWrapper
{

	/**
	 * Общее количество аудиофайлов профиля пользователя.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#userprofileaudios
	 */
	public function getTotalCount(): int
	{
		return (int)$this->getData("total_count");
	}

	/**
	 * Запрошенные аудиофайлы профиля.
	 *
	 * @return Audio[]
	 * @see https://core.telegram.org/bots/api#userprofileaudios
	 */
	public function getAudios(): array
	{
		return array_map(static fn(array $item): Audio => new Audio($item), (array)$this->getData("audios", []));
	}

}
