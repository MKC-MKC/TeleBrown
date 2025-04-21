<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * LoginUrl – This object represents a parameter of the inline keyboard button used to automatically authorize a user.
 * Serves as a great replacement for the Telegram Login Widget when the user is coming from Telegram.
 * All the user needs to do is tap/click a button and confirm that they want to log in:
 * @see https://core.telegram.org/bots/api#loginurl
 */
class LoginUrl
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

	public function getUrl(): string
	{
		return (string)$this->getAsArray()["url"] ?? "";
	}

	public function getForwardText(): ?string
	{
		return (string)$this->getAsArray()["forward_text"] ?? null;
	}

	public function getBotUsername(): ?string
	{
		return (string)$this->getAsArray()["bot_username"] ?? null;
	}

	public function hasRequestWriteAccess(): bool
	{
		return (bool)$this->getAsArray()["request_write_access"] ?? false;
	}

}
