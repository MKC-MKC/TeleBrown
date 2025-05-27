<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * KeyboardButton – This object represents one button of the reply keyboard.
 * At most one of the optional fields must be used to specify type of the button.
 * For simple text buttons, String can be used instead of this object to specify the button text.
 * @see https://core.telegram.org/bots/api#keyboardbutton
 */
class KeyboardButton extends ResponseWrapper
{

	public function getText(): string
	{
		return (string)$this->getData("text");
	}

	public function getRequestUser(): KeyboardButtonRequestUsers
	{
		$data = (array)$this->getData("request_user", []);
		return new KeyboardButtonRequestUsers($data);
	}

	public function getRequestChat(): KeyboardButtonRequestChat
	{
		$data = (array)$this->getData("request_chat", []);
		return new KeyboardButtonRequestChat($data);
	}

	public function isRequestContact(): bool
	{
		return (bool)$this->getData("request_contact");
	}

	public function isRequestLocation(): bool
	{
		return (bool)$this->getData("request_location");
	}

	public function getRequestPoll(): array
	{
		return (array)$this->getData("request_poll");
	}

	public function getWebApp(): array
	{
		return (array)$this->getData("web_app");
	}

}
