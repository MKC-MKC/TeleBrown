<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class PaidMedia extends ResponseWrapper
{

	/**
	 * Тип платного медиа: preview, photo, video или live_photo.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#paidmedia
	 */
	public function getType(): string
	{
		return (string)$this->getData("type");
	}

	/**
	 * Необязательно. Ширина превью, указанная отправителем.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#paidmedia
	 */
	public function getWidth(): int|null
	{
		return $this->getData("width");
	}

	/**
	 * Необязательно. Высота превью, указанная отправителем.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#paidmedia
	 */
	public function getHeight(): int|null
	{
		return $this->getData("height");
	}

	/**
	 * Необязательно. Длительность превью в секундах, указанная отправителем.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#paidmedia
	 */
	public function getDuration(): int|null
	{
		return $this->getData("duration");
	}

	/**
	 * Необязательно. Фотография для типа photo.
	 *
	 * @return PhotoSize[]
	 * @see https://core.telegram.org/bots/api#paidmedia
	 */
	public function getPhoto(): array
	{
		return array_map(static fn(array $item): PhotoSize => new PhotoSize($item), (array)$this->getData("photo", []));
	}

	/**
	 * Необязательно. Видео для типа video.
	 *
	 * @return Video|null
	 * @see https://core.telegram.org/bots/api#paidmedia
	 */
	public function getVideo(): Video|null
	{
		$data = $this->getData("video");
		return $data === null ? null : new Video($data);
	}

	/**
	 * Необязательно. Живая фотография для типа live_photo.
	 *
	 * @return LivePhoto|null
	 * @see https://core.telegram.org/bots/api#paidmedia
	 */
	public function getLivePhoto(): LivePhoto|null
	{
		$data = $this->getData("live_photo");
		return $data === null ? null : new LivePhoto($data);
	}

}
