<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class ChatJoinRequest extends ResponseWrapper
{

	/**
	 * Метод возвращает чат, в который отправлен запрос на присоединение.
	 *
	 * @return Chat
	 */
	public function getChat(): Chat
	{
		return new Chat((array)$this->getData("chat", []));
	}

	/**
	 * Метод возвращает пользователя, отправившего запрос.
	 *
	 * @return User
	 */
	public function getFrom(): User
	{
		return new User((array)$this->getData("from", []));
	}

	/**
	 * Метод возвращает идентификатор временно доступного личного чата пользователя.
	 *
	 * @return int
	 */
	public function getUserChatId(): int
	{
		return (int)$this->getData("user_chat_id");
	}

	/**
	 * Метод возвращает время отправки запроса в Unix-формате.
	 *
	 * @return int
	 */
	public function getDate(): int
	{
		return (int)$this->getData("date");
	}

	/**
	 * Метод возвращает биографию пользователя при её наличии.
	 *
	 * @return string|null
	 */
	public function getBio(): string|null
	{
		$value = $this->getData("bio");

		return $value === null ? null : (string)$value;
	}

	/**
	 * Метод возвращает использованную ссылку-приглашение при её наличии.
	 *
	 * @return ChatInviteLink|null
	 */
	public function getInviteLink(): ChatInviteLink|null
	{
		$data = $this->getData("invite_link");

		return is_array($data) ? new ChatInviteLink($data) : null;
	}

	/**
	 * Метод возвращает идентификатор запроса для назначенного guard-бота.
	 *
	 * @return string|null
	 */
	public function getQueryId(): string|null
	{
		$value = $this->getData("query_id");

		return $value === null ? null : (string)$value;
	}

}
