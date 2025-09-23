<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * Voice – This object represents a voice note.
 *
 * @see https://core.telegram.org/bots/api#voice
 */
class Voice extends ResponseWrapper
{

	/**
	 * Идентификатор этого файла, который можно использовать для загрузки или повторного использования файла
	 * Identifier for this file, which can be used to download or reuse the file
	 *
	 * @return string
	 */
	public function getFileId(): string
	{
		return (string)$this->getData("file_id");
	}

	/**
	 * Уникальный идентификатор этого файла, который должен оставаться неизменным с течением времени и для разных ботов.
	 * Не может быть использован для загрузки или повторного использования файла.
	 *
	 * Unique identifier for this file, which is supposed to be the same over time and for different bots.
	 * Can't be used to download or reuse the file.
	 *
	 * @return string
	 */
	public function getFileUniqueId(): string
	{
		return (string)$this->getData("file_unique_id");
	}

	/**
	 * Длительность аудио в секундах, определяемая отправителем
	 * Duration of the audio in seconds as defined by the sender
	 *
	 * @return int
	 */
	public function getDuration(): int
	{
		return (int)$this->getData("duration");
	}

	/**
	 * Опционально. MIME тип файла, определяемый отправителем
	 * Optional. MIME type of the file as defined by the sender
	 *
	 * @return string
	 */
	public function getMimeType(): string
	{
		return (string)$this->getData("mime_type");
	}

	/**
	 * Опционально. Размер файла в байтах.
	 * Он может быть больше, чем 2^31, и некоторым языкам программирования может быть трудно/тихо интерпретировать его.
	 * Но у него есть не более 52 значащих бит, поэтому для хранения этого значения безопасны знаковый 64-битный int
	 * или тип с float двойной точности для хранения этого значения.
	 *
	 * Optional. File size in bytes.
	 * It can be bigger than 2^31 and some programming languages may have difficulty/silent defects in interpreting it.
	 * But it has at most 52 significant bits, so a signed 64-bit integer
	 * or double-precision float type are safe for storing this value.
	 *
	 * @return int
	 */
	public function getFileSize(): int
	{
		return (int)$this->getData("file_size");
	}

}
