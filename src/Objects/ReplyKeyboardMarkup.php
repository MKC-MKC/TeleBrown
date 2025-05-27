<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * ReplyKeyboardMarkup – This object represents a custom keyboard with reply options (see Introduction to bots for details and examples).
 * Not supported in channels and for messages sent on behalf of a Telegram Business account.
 * @see https://core.telegram.org/bots/api#replykeyboardmarkup
 */
class ReplyKeyboardMarkup extends ResponseWrapper
{

	public function getKeyboard(): array
	{
		return (array)$this->getData("keyboard");
	}

	public function isPersistent(): bool
	{
		return (bool)$this->getData("is_persistent");
	}

	public function isResizeKeyboard(): bool
	{
		return (bool)$this->getData("resize_keyboard");
	}

	public function isOneTimeKeyboard(): bool
	{
		return (bool)$this->getData("one_time_keyboard");
	}

	public function isSelective(): bool
	{
		return (bool)$this->getData("selective");
	}

	public function getInputFieldPlaceholder(): string
	{
		return (string)$this->getData("input_field_placeholder");
	}

}
