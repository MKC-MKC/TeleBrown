<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class LivePhoto extends ResponseWrapper
{

	/**
	 * Необязательно. Доступные размеры статичной фотографии.
	 *
	 * @return PhotoSize[]
	 * @see https://core.telegram.org/bots/api#livephoto
	 */
	public function getPhoto(): array
	{
		return array_map(static fn(array $item): PhotoSize => new PhotoSize($item), (array)$this->getData("photo", []));
	}

	/**
	 * Идентификатор видеофайла для скачивания или повторного использования.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#livephoto
	 */
	public function getFileId(): string
	{
		return (string)$this->getData("file_id");
	}

	/**
	 * Уникальный идентификатор видеофайла, одинаковый для разных ботов; не подходит для скачивания.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#livephoto
	 */
	public function getFileUniqueId(): string
	{
		return (string)$this->getData("file_unique_id");
	}

	/**
	 * Ширина видео, указанная отправителем.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#livephoto
	 */
	public function getWidth(): int
	{
		return (int)$this->getData("width");
	}

	/**
	 * Высота видео, указанная отправителем.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#livephoto
	 */
	public function getHeight(): int
	{
		return (int)$this->getData("height");
	}

	/**
	 * Длительность видео в секундах, указанная отправителем.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#livephoto
	 */
	public function getDuration(): int
	{
		return (int)$this->getData("duration");
	}

	/**
	 * Необязательно. MIME-тип файла, указанный отправителем.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#livephoto
	 */
	public function getMimeType(): string|null
	{
		return $this->getData("mime_type");
	}

	/**
	 * Необязательно. Размер файла в байтах.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#livephoto
	 */
	public function getFileSize(): int|null
	{
		return $this->getData("file_size");
	}

}
