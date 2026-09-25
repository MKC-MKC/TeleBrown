<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class BotCommandScope extends ResponseWrapper
{

	/**
	 * Тип области: default, all_private_chats, all_group_chats, all_chat_administrators, chat, chat_administrators или chat_member.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#botcommandscope
	 */
	public function getType(): string
	{
		return (string)$this->getData("type");
	}

	/**
	 * Идентификатор чата или @username супергруппы для областей chat, chat_administrators и chat_member.
	 *
	 * @return int|string|null
	 * @see https://core.telegram.org/bots/api#botcommandscope
	 */
	public function getChatId(): int|string|null
	{
		return $this->getData("chat_id");
	}

	/**
	 * Идентификатор пользователя для области chat_member.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#botcommandscope
	 */
	public function getUserId(): int|null
	{
		return $this->getData("user_id");
	}

}
