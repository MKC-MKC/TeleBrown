<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class InputProfilePhoto extends ResponseWrapper
{

	/**
	 * Тип фотографии профиля: static или animated.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#inputprofilephotostatic
	 */
	public function getType(): string
	{
		return (string)$this->getData("type");
	}

	/**
	 * Статическая фотография профиля. Можно загрузить только новый файл через attach://<file_attach_name>.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputprofilephotostatic
	 */
	public function getPhoto(): string|null
	{
		return $this->getData("photo");
	}

	/**
	 * Анимированная фотография профиля. Можно загрузить только новый файл через attach://<file_attach_name>.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputprofilephotoanimated
	 */
	public function getAnimation(): string|null
	{
		return $this->getData("animation");
	}

	/**
	 * Необязательно. Время кадра в секундах для статической фотографии профиля. По умолчанию 0.0.
	 *
	 * @return float|null
	 * @see https://core.telegram.org/bots/api#inputprofilephotoanimated
	 */
	public function getMainFrameTimestamp(): float|null
	{
		return $this->getData("main_frame_timestamp");
	}

}
