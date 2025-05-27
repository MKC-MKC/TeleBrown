<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * Animation
 * This object represents an animation file (GIF or H.264/MPEG-4 AVC video without sound).
 * @see https://core.telegram.org/bots/api#animation
 */
class Animation extends ResponseWrapper
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

	public function getHeigh(): int
	{
		return (int)$this->getData("height");
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
