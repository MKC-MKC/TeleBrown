<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * PhotoSize – This object represents one size of a photo or a file / sticker thumbnail.
 * @see https://core.telegram.org/bots/api#photosize
 */
class PhotoSize
{
	private array $response;

	public function __construct(array $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array
	{
		return $this->response ?? [];
	}

	public function getFileId(): string
	{
		return (string)$this->getAsArray()["file_id"] ?? "";
	}

	public function getFileUniqueId(): string
	{
		return (string)$this->getAsArray()["file_unique_id"] ?? "";
	}

	public function getWidth(): int
	{
		return (int)$this->getAsArray()["width"] ?? 0;
	}

	public function getHeight(): int
	{
		return (int)$this->getAsArray()["height"] ?? 0;
	}

	public function getFileSize(): ?int
	{
		return $this->getAsArray()["file_size"] ?? null;
	}

}
