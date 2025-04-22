<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * SwitchInlineQueryChosenChat – This object represents an inline button that switches the current user
 * to inline mode in a chosen chat, with an optional default inline query.
 * @see https://core.telegram.org/bots/api#switchinlinequerychosenchat
 */
class SwitchInlineQueryChosenChat extends Type
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	public function getQuery(): ?string
	{
		return (string)$this->getData("query") ?? null;
	}

	public function isAllowUserChats(): ?bool
	{
		return (bool)$this->getData("allow_user_chats") ?? null;
	}

	public function isAllowBotChats(): ?bool
	{
		return (bool)$this->getData("allow_bot_chats") ?? null;
	}

	public function isAllowGroupChats(): ?bool
	{
		return (bool)$this->getData("allow_group_chats") ?? null;
	}

	public function isAllowChannelChats(): ?bool
	{
		return (bool)$this->getData("allow_channel_chats") ?? null;
	}

}
