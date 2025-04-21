<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * CopyTextButton – This object represents an inline keyboard button that copies specified text to the clipboard.
 * @see https://core.telegram.org/bots/api#copytextbutton
 */
class CopyTextButton
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

	public function getText(): string
	{
		return (string)$this->response["text"] ?? "";
	}

}
