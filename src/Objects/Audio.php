<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * Audio – This object represents an audio file to be treated as music by the Telegram clients.
 * @see https://core.telegram.org/bots/api#audio
 */
class Audio extends ResponseWrapper
{

	public function getFileId(): string
	{
		return (string)$this->getData("file_id");
	}

	public function getFileUniqueId(): string
	{
		return (string)$this->getData("file_unique_id");
	}

	public function getDuration(): int
	{
		return (int)$this->getData("file_unique_id");
	}

	public function getPerformer(): string
	{
		return (string)$this->getData("performer");
	}

	public function getTitle(): string
	{
		return (string)$this->getData("title");
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

	public function getThumbnail(): object
	{
		$data = (array)$this->getData("thumbnail", []);
		return new PhotoSize($data);
	}

}
