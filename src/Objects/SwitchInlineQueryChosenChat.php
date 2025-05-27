<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * SwitchInlineQueryChosenChat – This object represents an inline button that switches the current user
 * to inline mode in a chosen chat, with an optional default inline query.
 * @see https://core.telegram.org/bots/api#switchinlinequerychosenchat
 */
class SwitchInlineQueryChosenChat extends ResponseWrapper
{

	public function getQuery(): string
	{
		return (string)$this->getData("query");
	}

	public function isAllowUserChats(): bool
	{
		return (bool)$this->getData("allow_user_chats");
	}

	public function isAllowBotChats(): bool
	{
		return (bool)$this->getData("allow_bot_chats");
	}

	public function isAllowGroupChats(): bool
	{
		return (bool)$this->getData("allow_group_chats");
	}

	public function isAllowChannelChats(): bool
	{
		return (bool)$this->getData("allow_channel_chats");
	}

}
