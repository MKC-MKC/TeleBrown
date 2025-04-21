<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * SwitchInlineQueryChosenChat – This object represents an inline button that switches the current user
 * to inline mode in a chosen chat, with an optional default inline query.
 * @see https://core.telegram.org/bots/api#switchinlinequerychosenchat
 */
class SwitchInlineQueryChosenChat
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

	public function getQuery(): ?string
	{
		return (string)$this->getAsArray()["query"] ?? null;
	}

	public function isAllowUserChats(): ?bool
	{
		return (bool)$this->getAsArray()["allow_user_chats"] ?? null;
	}

	public function isAllowBotChats(): ?bool
	{
		return (bool)$this->getAsArray()["allow_bot_chats"] ?? null;
	}

	public function isAllowGroupChats(): ?bool
	{
		return (bool)$this->getAsArray()["allow_group_chats"] ?? null;
	}

	public function isAllowChannelChats(): ?bool
	{
		return (bool)$this->getAsArray()["allow_channel_chats"] ?? null;
	}

}
