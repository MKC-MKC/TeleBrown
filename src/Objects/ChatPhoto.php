<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * ChatPhoto – This object represents a chat photo.
 * @see https://core.telegram.org/bots/api#chatphoto
 */
class ChatPhoto extends ResponseWrapper
{

	/**
	 * File identifier of small (160x160) chat photo.
	 * This file_id can be used only for photo download and only for as long as the photo is not changed.
	 * @return string
	 */
	public function getSmallFileId(): string
	{
		return (string)$this->getData("small_file_id");
	}

	/**
	 * Unique file identifier of small (160x160) chat photo,
	 * which is supposed to be the same over time and for different bots.
	 * Can't be used to download or reuse the file.
	 * @return string
	 */
	public function getSmallFileUniqueId(): string
	{
		return (string)$this->getData("small_file_unique_id");
	}

	/**
	 * File identifier of big (640x640) chat photo.
	 * This file_id can be used only for photo download and only for as long as the photo is not changed.
	 * @return string
	 */
	public function getBigFileId(): string
	{
		return (string)$this->getData("big_file_id");
	}

	/**
	 * Unique file identifier of big (640x640) chat photo,
	 * which is supposed to be the same over time and for different bots.
	 * Can't be used to download or reuse the file.
	 * @return string
	 */
	public function getBigFileUniqueId(): string
	{
		return (string)$this->getData("big_file_unique_id");
	}

}
