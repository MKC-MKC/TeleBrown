<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * InlineKeyboardMarkup – This object represents an inline keyboard that appears right next to the message it belongs to.
 * @see https://core.telegram.org/bots/api#inlinekeyboardmarkup
 */
class InlineKeyboardMarkup extends ResponseWrapper
{

	public static function buttons(array $buttons): self
	{
		return new self([
			"inline_keyboard" => [$buttons],
		]);
	}

	/**
	 * Array of button rows, each represented by an Array of InlineKeyboardButton objects
	 *
	 * @return array of Array of InlineKeyboardButton
	 */
	public function getInlineKeyboard(): array
	{
		return (array)$this->getData("inline_keyboard");
	}

}
