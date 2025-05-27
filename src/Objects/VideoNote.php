<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * VideoNote
 * This object represents a video message (available in Telegram apps as of v.4.0).
 * @see https://core.telegram.org/bots/api#videonote
 */
class VideoNote extends ResponseWrapper
{

	public function getFileId(): string
	{
		return (string)$this->getData("file_id");
	}

	public function getFileUniqueId(): string
	{
		return (string)$this->getData("file_unique_id");
	}

	public function getLength(): int
	{
		return (int)$this->getData("length");
	}

	public function getDuration(): int
	{
		return (int)$this->getData("duration");
	}

	public function getThumbnail(): object
	{
		$data = (array)$this->getData("thumbnail", []);
		return new PhotoSize($data);
	}

	public function getFileSize(): int
	{
		return (int)$this->getData("file_size");
	}

}
