<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * KeyboardButtonRequestChat – This object defines the criteria used to request a suitable chat.
 * Information about the selected chat will be shared with the bot when the corresponding button is pressed.
 * The bot will be granted requested rights in the chat if appropriate.
 * @see https://core.telegram.org/bots/api#keyboardbuttonrequestchat
 */
class KeyboardButtonRequestChat extends Type
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	public function getRequestId(): int
	{
		return (int)$this->getData("request_id") ?? 0;
	}

	public function isChannelRequested(): bool
	{
		return ($this->getData("chat_is_channel") ?? false);
	}

	public function isForumRequested(): bool
	{
		return ($this->getData("chat_is_forum") ?? false);
	}

	public function hasUsernameRequested(): bool
	{
		return ($this->getData("chat_has_username") ?? false);
	}

	public function isCreatedRequested(): bool
	{
		return ($this->getData("chat_is_created") ?? false);
	}

	public function getUserAdministratorRights(): ?ChatAdministratorRights
	{
		return ($data = $this->getData("user_administrator_rights")) && is_array($data) ? new ChatAdministratorRights($data) : null;
	}

	public function getBotAdministratorRights(): ?ChatAdministratorRights
	{
		return ($data = $this->getData("bot_administrator_rights")) && is_array($data) ? new ChatAdministratorRights($data) : null;
	}

	public function isBotMemberRequested(): bool
	{
		return ($this->getData("bot_is_member") ?? false);
	}

	public function hasRequestTitle(): bool
	{
		return ($this->getData("request_title") ?? false);
	}

	public function hasRequestUsername(): bool
	{
		return ($this->getData("request_username") ?? false);
	}

	public function hasRequestPhoto(): bool
	{
		return ($this->getData("request_photo") ?? false);
	}

}
