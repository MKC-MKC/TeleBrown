<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * ChatPhoto – This object represents a chat photo.
 * @see https://core.telegram.org/bots/api#chatphoto
 */
class ChatPhoto extends Type
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	public function getSmallFileId(): string
	{
		return (string)$this->getData("small_file_id") ?? "";
	}

	public function getSmallFileUniqueId(): string
	{
		return (string)$this->getData("small_file_unique_id") ?? "";
	}

	public function getBigFileId(): string
	{
		return (string)$this->getData("big_file_id") ?? "";
	}

	public function getBigFileUniqueId(): string
	{
		return (string)$this->getData("big_file_unique_id") ?? "";
	}

}
