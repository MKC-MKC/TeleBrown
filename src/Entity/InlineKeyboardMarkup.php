<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * InlineKeyboardMarkup – This object represents an inline keyboard that appears right next to the message it belongs to.
 * @see https://core.telegram.org/bots/api#inlinekeyboardmarkup
 */
class InlineKeyboardMarkup
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

	/**
	 * Array of button rows, each represented by an Array of InlineKeyboardButton objects
	 *
	 * @return array of Array of InlineKeyboardButton
	 */
	public function getInlineKeyboard(): array
	{
		return $this->getAsArray()["inline_keyboard"] ?? [];
	}

}
