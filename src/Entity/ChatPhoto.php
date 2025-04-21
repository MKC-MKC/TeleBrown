<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * ChatPhoto – This object represents a chat photo.
 * @see https://core.telegram.org/bots/api#chatphoto
 */
class ChatPhoto
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

	public function getSmallFileId(): string
	{
		return (string)$this->getAsArray()["small_file_id"] ?? "";
	}

	public function getSmallFileUniqueId(): string
	{
		return (string)$this->getAsArray()["small_file_unique_id"] ?? "";
	}

	public function getBigFileId(): string
	{
		return (string)$this->getAsArray()["big_file_id"] ?? "";
	}

	public function getBigFileUniqueId(): string
	{
		return (string)$this->getAsArray()["big_file_unique_id"] ?? "";
	}

}
