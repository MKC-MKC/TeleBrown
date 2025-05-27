<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * KeyboardButtonRequestChat – This object defines the criteria used to request a suitable chat.
 * Information about the selected chat will be shared with the bot when the corresponding button is pressed.
 * The bot will be granted requested rights in the chat if appropriate.
 * @see https://core.telegram.org/bots/api#keyboardbuttonrequestchat
 */
class KeyboardButtonRequestChat extends ResponseWrapper
{

	public function getRequestId(): int
	{
		return (int)$this->getData("request_id");
	}

	public function isChannelRequested(): bool
	{
		return (bool)$this->getData("chat_is_channel");
	}

	public function isForumRequested(): bool
	{
		return (bool)$this->getData("chat_is_forum");
	}

	public function hasUsernameRequested(): bool
	{
		return (bool)$this->getData("chat_has_username");
	}

	public function isCreatedRequested(): bool
	{
		return (bool)$this->getData("chat_is_created");
	}

	public function getUserAdministratorRights(): ChatAdministratorRights
	{
		$data = (array)$this->getData("user_administrator_rights", []);
		return new ChatAdministratorRights($data);
	}

	public function getBotAdministratorRights(): ChatAdministratorRights
	{
		$data = (array)$this->getData("bot_administrator_rights", []);
		return new ChatAdministratorRights($data);
	}

	public function isBotMemberRequested(): bool
	{
		return (bool)$this->getData("bot_is_member");
	}

	public function hasRequestTitle(): bool
	{
		return (bool)$this->getData("request_title");
	}

	public function hasRequestUsername(): bool
	{
		return (bool)$this->getData("request_username");
	}

	public function hasRequestPhoto(): bool
	{
		return (bool)$this->getData("request_photo");
	}

}
