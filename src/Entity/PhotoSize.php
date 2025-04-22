<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * PhotoSize – This object represents one size of a photo or a file / sticker thumbnail.
 * @see https://core.telegram.org/bots/api#photosize
 */
class PhotoSize extends Type
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	public function getFileId(): string
	{
		return (string)$this->getData("file_id") ?? "";
	}

	public function getFileUniqueId(): string
	{
		return (string)$this->getData("file_unique_id") ?? "";
	}

	public function getWidth(): int
	{
		return (int)$this->getData("width") ?? 0;
	}

	public function getHeight(): int
	{
		return (int)$this->getData("height") ?? 0;
	}

	public function getFileSize(): ?int
	{
		return $this->getData("file_size") ?? null;
	}

}
