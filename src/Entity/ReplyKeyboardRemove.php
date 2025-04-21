<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * ReplyKeyboardRemove – Upon receiving a message with this object, Telegram clients will remove the current custom keyboard and display the default letter-keyboard.
 * By default, custom keyboards are displayed until a new keyboard is sent by a bot.
 * An exception is made for one-time keyboards that are hidden immediately after the user presses a button (see ReplyKeyboardMarkup).
 * Not supported in channels and for messages sent on behalf of a Telegram Business account.
 * @see https://core.telegram.org/bots/api#replykeyboardremove
 */
class ReplyKeyboardRemove
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

	public function isRemoveKeyboard(): bool
	{
		return (bool)$this->getAsArray()["remove_keyboard"] ?? false;
	}

	public function isSelective(): ?bool
	{
		return ($this->getAsArray()["selective"] ?? false) ?? null;
	}

}
