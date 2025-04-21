<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * KeyboardButton – This object represents one button of the reply keyboard.
 * At most one of the optional fields must be used to specify type of the button.
 * For simple text buttons, String can be used instead of this object to specify the button text.
 * @see https://core.telegram.org/bots/api#keyboardbutton
 */
class KeyboardButton
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
		return (string)$this->getAsArray()["text"] ?? "";
	}

	public function getRequestUser(): KeyboardButtonRequestUsers
	{
		return new KeyboardButtonRequestUsers($this->getAsArray()["request_user"] ?? []);
	}

	public function getRequestChat(): KeyboardButtonRequestChat
	{
		return new KeyboardButtonRequestChat($this->getAsArray()["request_chat"] ?? []);
	}

	public function isRequestContact(): bool
	{
		return ($this->getAsArray()["request_contact"] ?? false);
	}

	public function isRequestLocation(): bool
	{
		return ($this->getAsArray()["request_location"] ?? false);
	}

	public function getRequestPoll(): array
	{
		return $this->getAsArray()["request_poll"] ?? [];
	}

	public function getWebApp(): array
	{
		return $this->getAsArray()["web_app"] ?? [];
	}

}
