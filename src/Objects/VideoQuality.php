<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class VideoQuality extends ResponseWrapper
{

	/**
	 * Идентификатор файла для скачивания или повторного использования.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#videoquality
	 */
	public function getFileId(): string
	{
		return (string)$this->getData("file_id");
	}

	/**
	 * Уникальный идентификатор файла, одинаковый для разных ботов; не подходит для скачивания.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#videoquality
	 */
	public function getFileUniqueId(): string
	{
		return (string)$this->getData("file_unique_id");
	}

	/**
	 * Ширина видео.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#videoquality
	 */
	public function getWidth(): int
	{
		return (int)$this->getData("width");
	}

	/**
	 * Высота видео.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#videoquality
	 */
	public function getHeight(): int
	{
		return (int)$this->getData("height");
	}

	/**
	 * Кодек видео, например h264, h265 или av01.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#videoquality
	 */
	public function getCodec(): string
	{
		return (string)$this->getData("codec");
	}

	/**
	 * Необязательно. Размер файла в байтах.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#videoquality
	 */
	public function getFileSize(): int|null
	{
		return $this->getData("file_size");
	}

}
