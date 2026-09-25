<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class BusinessConnection extends ResponseWrapper
{

	/**
	 * Уникальный идентификатор бизнес-подключения.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#businessconnection
	 */
	public function getId(): string
	{
		return (string)$this->getData("id");
	}

	/**
	 * Пользователь бизнес-аккаунта, создавший подключение.
	 *
	 * @return User
	 * @see https://core.telegram.org/bots/api#businessconnection
	 */
	public function getUser(): User
	{
		$data = $this->getData("user");
		return new User($data);
	}

	/**
	 * Идентификатор личного чата с пользователем, создавшим подключение.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#businessconnection
	 */
	public function getUserChatId(): int
	{
		return (int)$this->getData("user_chat_id");
	}

	/**
	 * Дата создания подключения в Unix-времени.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#businessconnection
	 */
	public function getDate(): int
	{
		return (int)$this->getData("date");
	}

	/**
	 * Необязательно. Права бизнес-бота.
	 *
	 * @return BusinessBotRights|null
	 * @see https://core.telegram.org/bots/api#businessconnection
	 */
	public function getRights(): BusinessBotRights|null
	{
		$data = $this->getData("rights");
		return $data === null ? null : new BusinessBotRights($data);
	}

	/**
	 * True, если подключение активно.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#businessconnection
	 */
	public function isEnabled(): bool
	{
		return (bool)$this->getData("is_enabled");
	}

}
