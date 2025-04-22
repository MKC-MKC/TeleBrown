<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * ReplyKeyboardMarkup – This object represents a custom keyboard with reply options (see Introduction to bots for details and examples).
 * Not supported in channels and for messages sent on behalf of a Telegram Business account.
 * @see https://core.telegram.org/bots/api#replykeyboardmarkup
 */
class ReplyKeyboardMarkup extends Type
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	public function getKeyboard(): array
	{
		return $this->getData("keyboard") ?? [];
	}

	public function isPersistent(): bool
	{
		return ($this->getData("is_persistent") ?? false);
	}

	public function isResizeKeyboard(): bool
	{
		return ($this->getData("resize_keyboard") ?? false);
	}

	public function isOneTimeKeyboard(): bool
	{
		return ($this->getData("one_time_keyboard") ?? false);
	}

	public function getInputFieldPlaceholder(): ?string
	{
		return (string)$this->getData("input_field_placeholder") ?? null;
	}

	public function isSelective(): bool
	{
		return ($this->getData("selective") ?? false);
	}

}
