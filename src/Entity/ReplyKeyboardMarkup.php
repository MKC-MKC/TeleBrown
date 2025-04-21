<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * ReplyKeyboardMarkup – This object represents a custom keyboard with reply options (see Introduction to bots for details and examples).
 * Not supported in channels and for messages sent on behalf of a Telegram Business account.
 * @see https://core.telegram.org/bots/api#replykeyboardmarkup
 */
class ReplyKeyboardMarkup
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

	public function getKeyboard(): array
	{
		return $this->getAsArray()["keyboard"] ?? [];
	}

	public function isPersistent(): bool
	{
		return ($this->getAsArray()["is_persistent"] ?? false);
	}

	public function isResizeKeyboard(): bool
	{
		return ($this->getAsArray()["resize_keyboard"] ?? false);
	}

	public function isOneTimeKeyboard(): bool
	{
		return ($this->getAsArray()["one_time_keyboard"] ?? false);
	}

	public function getInputFieldPlaceholder(): ?string
	{
		return (string)$this->getAsArray()["input_field_placeholder"] ?? null;
	}

	public function isSelective(): bool
	{
		return ($this->getAsArray()["selective"] ?? false);
	}

}
