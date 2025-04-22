<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * CopyTextButton – This object represents an inline keyboard button that copies specified text to the clipboard.
 * @see https://core.telegram.org/bots/api#copytextbutton
 */
class CopyTextButton extends Type
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	public function getText(): string
	{
		return (string)$this->response["text"] ?? "";
	}

}
