<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class Video extends ResponseWrapper
{

	/**
	 * Идентификатор файла для скачивания или повторного использования.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#video
	 */
	public function getFileId(): string
	{
		return (string)$this->getData("file_id");
	}

	/**
	 * Уникальный идентификатор файла, одинаковый для разных ботов; не подходит для скачивания.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#video
	 */
	public function getFileUniqueId(): string
	{
		return (string)$this->getData("file_unique_id");
	}

	/**
	 * Ширина видео, указанная отправителем.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#video
	 */
	public function getWidth(): int
	{
		return (int)$this->getData("width");
	}

	/**
	 * Высота видео, указанная отправителем.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#video
	 */
	public function getHeight(): int
	{
		return (int)$this->getData("height");
	}

	/**
	 * Длительность видео в секундах, указанная отправителем.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#video
	 */
	public function getDuration(): int
	{
		return (int)$this->getData("duration");
	}

	/**
	 * Необязательно. Миниатюра видео.
	 *
	 * @return PhotoSize|null
	 * @see https://core.telegram.org/bots/api#video
	 */
	public function getThumbnail(): PhotoSize|null
	{
		$data = $this->getData("thumbnail");
		return $data === null ? null : new PhotoSize($data);
	}

	/**
	 * Необязательно. Доступные размеры обложки видео в сообщении.
	 *
	 * @return PhotoSize[]
	 * @see https://core.telegram.org/bots/api#video
	 */
	public function getCover(): array
	{
		return array_map(static fn(array $item): PhotoSize => new PhotoSize($item), (array)$this->getData("cover", []));
	}

	/**
	 * Необязательно. Момент в секундах, с которого начинается воспроизведение видео.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#video
	 */
	public function getStartTimestamp(): int|null
	{
		return $this->getData("start_timestamp");
	}

	/**
	 * Необязательно. Список доступных вариантов качества видео.
	 *
	 * @return VideoQuality[]
	 * @see https://core.telegram.org/bots/api#video
	 */
	public function getQualities(): array
	{
		return array_map(static fn(array $item): VideoQuality => new VideoQuality($item), (array)$this->getData("qualities", []));
	}

	/**
	 * Необязательно. Исходное имя файла, указанное отправителем.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#video
	 */
	public function getFileName(): string|null
	{
		return $this->getData("file_name");
	}

	/**
	 * Необязательно. MIME-тип файла, указанный отправителем.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#video
	 */
	public function getMimeType(): string|null
	{
		return $this->getData("mime_type");
	}

	/**
	 * Необязательно. Размер файла в байтах.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#video
	 */
	public function getFileSize(): int|null
	{
		return $this->getData("file_size");
	}

}
