<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * CopyTextButton – This object represents an inline keyboard button that copies specified text to the clipboard.
 * @see https://core.telegram.org/bots/api#copytextbutton
 */
class CopyTextButton extends ResponseWrapper
{

	public function getText(): string
	{
		return (string)$this->getData("text");
	}

}
