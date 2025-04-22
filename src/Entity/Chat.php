<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * Chat – This object represents a chat.
 * @see https://core.telegram.org/bots/api#chat
 */
class Chat
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

	/**
	 * Извлечение и фильтрация данных.
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function getData(string $key): mixed
	{
		$data = $this->getAsArray();
		return array_key_exists($key, $data) ? $data[$key] : null;
	}

	/**
	 * Unique identifier for this chat.
	 * This number may have more than 32 significant bits
	 * and some programming languages may have difficulty/silent defects in interpreting it.
	 * But it has at most 52 significant bits,
	 * so a signed 64-bit integer or double-precision float type are safe for storing this identifier.
	 *
	 * @return int
	 */
	public function getId(): int
	{
		return (int)$this->getData("id") ?? 0;
	}

	/**
	 * Type of the chat, can be either “private”, “group”, “supergroup” or “channel”
	 *
	 * @return string
	 */
	public function getType(): string
	{
		return (string)$this->getData("type") ?? "";
	}

	/**
	 * Type of the chat, can be either “private”, “group”, “supergroup” or “channel”
	 *
	 * @return string
	 */
	public function getTitle(): string
	{
		return (string)$this->getData("title") ?? "";
	}

	/**
	 * Optional. Username, for private chats, supergroups and channels if available
	 *
	 * @return string
	 */
	public function getUsername(): string
	{
		return (string)$this->getData("username") ?? "";
	}

	/**
	 * Optional. First name of the other party in a private chat
	 *
	 * @return string
	 */
	public function getFirstName(): string
	{
		return (string)$this->getData("first_name") ?? "";
	}

	/**
	 * Optional. Last name of the other party in a private chat
	 *
	 * @return string
	 */
	public function getLastName(): string
	{
		return (string)$this->getData("last_name") ?? "";
	}

	/**
	 * Optional. True, if the supergroup chat is a forum (has topics enabled)
	 *
	 * @return bool
	 */
	public function isForum(): bool
	{
		return ($this->getData("is_forum") ?? false);
	}

}
