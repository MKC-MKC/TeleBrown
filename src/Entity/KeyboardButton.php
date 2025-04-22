<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * KeyboardButton – This object represents one button of the reply keyboard.
 * At most one of the optional fields must be used to specify type of the button.
 * For simple text buttons, String can be used instead of this object to specify the button text.
 * @see https://core.telegram.org/bots/api#keyboardbutton
 */
class KeyboardButton extends Type
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
		return (string)$this->getData("text") ?? "";
	}

	public function getRequestUser(): KeyboardButtonRequestUsers
	{
		return new KeyboardButtonRequestUsers($this->getData("request_user"));
	}

	public function getRequestChat(): KeyboardButtonRequestChat
	{
		return new KeyboardButtonRequestChat($this->getData("request_chat"));
	}

	public function isRequestContact(): bool
	{
		return ($this->getData("request_contact") ?? false);
	}

	public function isRequestLocation(): bool
	{
		return ($this->getData("request_location") ?? false);
	}

	public function getRequestPoll(): array
	{
		return $this->getData("request_poll") ?? [];
	}

	public function getWebApp(): array
	{
		return $this->getData("web_app") ?? [];
	}

}
