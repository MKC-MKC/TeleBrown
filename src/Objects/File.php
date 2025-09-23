<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * File – This object represents a file ready to be downloaded.
 * The file can be downloaded via the link https://api.telegram.org/file/bot<token>/<file_path>.
 * It is guaranteed that the link will be valid for at least 1 hour.
 * When the link expires, a new one can be requested by calling getFile.
 *
 * > The maximum file size to download is 20 MB
 *
 * @see https://core.telegram.org/bots/api#file
 */
class File extends ResponseWrapper
{

	/**
	 * Идентификатор файла, который можно использовать для загрузки или повторного использования файла
	 * Identifier for this file, which can be used to download or reuse the file
	 *
	 * @return string
	 */
	public function getFileId(): string
	{
		return (string)$this->getData("file_id");
	}

	/**
	 * Уникальный идентификатор для этого файла, который, как предполагается, остается неизменным с течением времени и для разных ботов.
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
	 * Размер файла в байтах. Он может быть больше, чем 2^31, и некоторым языкам программирования может быть трудно/тихо интерпретировать его.
	 * Но у него не более 52 значащих бит, поэтому для хранения этого значения подходят знаковый 64-битный целочисленный тип или тип с плавающей запятой двойной точности.
	 *
	 * File size in bytes. It can be bigger than 2^31 and some programming languages may have difficulty/silent defects in interpreting it.
	 * But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this value.
	 *
	 * @return int|null
	 */
	public function getFileSize(): int|null
	{
		return $this->getData("file_size");
	}

	/**
	 * Путь к файлу. Используйте https://api.telegram.org/file/bot<token>/<file_path>, чтобы получить файл.
	 * File path. Use https://api.telegram.org/file/bot<token>/<file_path> to get the file.
	 *
	 * @return string|null
	 */
	public function getFilePath(): string|null
	{
		return $this->getData("file_path");
	}

}
