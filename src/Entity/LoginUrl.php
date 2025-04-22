<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * LoginUrl – This object represents a parameter of the inline keyboard button used to automatically authorize a user.
 * Serves as a great replacement for the Telegram Login Widget when the user is coming from Telegram.
 * All the user needs to do is tap/click a button and confirm that they want to log in:
 * @see https://core.telegram.org/bots/api#loginurl
 */
class LoginUrl extends Type
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	public function getUrl(): string
	{
		return (string)$this->getData("url") ?? "";
	}

	public function getForwardText(): ?string
	{
		return (string)$this->getData("forward_text") ?? null;
	}

	public function getBotUsername(): ?string
	{
		return (string)$this->getData("bot_username") ?? null;
	}

	public function hasRequestWriteAccess(): bool
	{
		return (bool)$this->getData("request_write_access") ?? false;
	}

}
