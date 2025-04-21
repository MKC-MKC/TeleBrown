<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * KeyboardButtonRequestChat – This object defines the criteria used to request a suitable chat.
 * Information about the selected chat will be shared with the bot when the corresponding button is pressed.
 * The bot will be granted requested rights in the chat if appropriate.
 * @see https://core.telegram.org/bots/api#keyboardbuttonrequestchat
 */
class KeyboardButtonRequestChat
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

	public function getRequestId(): int
	{
		return (int)$this->getAsArray()["request_id"] ?? 0;
	}

	public function isChannelRequested(): bool
	{
		return ($this->getAsArray()["chat_is_channel"] ?? false);
	}

	public function isForumRequested(): bool
	{
		return ($this->getAsArray()["chat_is_forum"] ?? false);
	}

	public function hasUsernameRequested(): bool
	{
		return ($this->getAsArray()["chat_has_username"] ?? false);
	}

	public function isCreatedRequested(): bool
	{
		return ($this->getAsArray()["chat_is_created"] ?? false);
	}

	public function getUserAdministratorRights(): ChatAdministratorRights
	{
		return new ChatAdministratorRights($this->getAsArray()["user_administrator_rights"] ?? []);
	}

	public function getBotAdministratorRights(): ChatAdministratorRights
	{
		return new ChatAdministratorRights($this->getAsArray()["bot_administrator_rights"] ?? []);
	}

	public function isBotMemberRequested(): bool
	{
		return ($this->getAsArray()["bot_is_member"] ?? false);
	}

	public function hasRequestTitle(): bool
	{
		return ($this->getAsArray()["request_title"] ?? false);
	}

	public function hasRequestUsername(): bool
	{
		return ($this->getAsArray()["request_username"] ?? false);
	}

	public function hasRequestPhoto(): bool
	{
		return ($this->getAsArray()["request_photo"] ?? false);
	}

}
