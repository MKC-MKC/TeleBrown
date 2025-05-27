<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * Document – This object represents a general file (as opposed to photos, voice messages and audio files).
 *
 * @see https://core.telegram.org/bots/api#document
 */
class Document extends ResponseWrapper
{

	public function getFileId(): string
	{
		return (string)$this->getData("file_id");
	}

	public function getFileUniqueId(): string
	{
		return (string)$this->getData("file_id");
	}

	public function getThumbnail(): object
	{
		$data = (array)$this->getData("thumbnail", []);
		return new PhotoSize($data);
	}

	public function getFileName(): string
	{
		return (string)$this->getData("file_name");
	}

	public function getMimeType(): string
	{
		return (string)$this->getData("mime_type");
	}

	public function getFileSize(): int
	{
		return (int)$this->getData("file_size");
	}

}
