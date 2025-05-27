<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * PhotoSize – This object represents one size of a photo or a file / sticker thumbnail.
 * @see https://core.telegram.org/bots/api#photosize
 */
class PhotoSize extends ResponseWrapper
{

	public function getFileId(): string
	{
		return (string)$this->getData("file_id");
	}

	public function getFileUniqueId(): string
	{
		return (string)$this->getData("file_unique_id");
	}

	public function getWidth(): int
	{
		return (int)$this->getData("width");
	}

	public function getHeight(): int
	{
		return (int)$this->getData("height");
	}

	public function getFileSize(): int
	{
		return (int)$this->getData("file_size");
	}

}
