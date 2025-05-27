<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class Voice extends ResponseWrapper
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
		return (int)$this->getData("duration");
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
