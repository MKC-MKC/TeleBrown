<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class ChatMemberUpdated extends ResponseWrapper
{

	/**
	 * Чат, к которому относится пользователь.
	 *
	 * @return Chat
	 * @see https://core.telegram.org/bots/api#chatmemberupdated
	 */
	public function getChat(): Chat
	{
		$data = $this->getData("chat");
		return new Chat($data);
	}

	/**
	 * Пользователь, выполнивший действие, вызвавшее изменение.
	 *
	 * @return User
	 * @see https://core.telegram.org/bots/api#chatmemberupdated
	 */
	public function getFrom(): User
	{
		$data = $this->getData("from");
		return new User($data);
	}

	/**
	 * Дата изменения в Unix-времени.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#chatmemberupdated
	 */
	public function getDate(): int
	{
		return (int)$this->getData("date");
	}

	/**
	 * Предыдущие сведения об участнике чата.
	 *
	 * @return ChatMember
	 * @see https://core.telegram.org/bots/api#chatmemberupdated
	 */
	public function getOldChatMember(): ChatMember
	{
		$data = $this->getData("old_chat_member");
		return ChatMember::getChatMember($data);
	}

	/**
	 * Новые сведения об участнике чата.
	 *
	 * @return ChatMember
	 * @see https://core.telegram.org/bots/api#chatmemberupdated
	 */
	public function getNewChatMember(): ChatMember
	{
		$data = $this->getData("new_chat_member");
		return ChatMember::getChatMember($data);
	}

	/**
	 * Необязательно. Ссылка-приглашение, использованная для вступления; только для вступления по ссылке.
	 *
	 * @return ChatInviteLink|null
	 * @see https://core.telegram.org/bots/api#chatmemberupdated
	 */
	public function getInviteLink(): ChatInviteLink|null
	{
		$data = $this->getData("invite_link");
		return $data === null ? null : new ChatInviteLink($data);
	}

	/**
	 * Необязательно. True, если пользователь вступил после прямой заявки без ссылки-приглашения и одобрения администратором.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#chatmemberupdated
	 */
	public function isViaJoinRequest(): bool
	{
		return (bool)$this->getData("via_join_request");
	}

	/**
	 * Необязательно. True, если пользователь вступил по ссылке-приглашению в папку чатов.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#chatmemberupdated
	 */
	public function isViaChatFolderInviteLink(): bool
	{
		return (bool)$this->getData("via_chat_folder_invite_link");
	}

}
