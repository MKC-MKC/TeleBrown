<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * User – This object represents a Telegram user or bot.
 * @see https://core.telegram.org/bots/api#user
 */
class User
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
	 * Unique identifier for this user or bot.
	 * This number may have more than 32 significant bits and some programming languages
	 * may have difficulty/silent defects in interpreting it.
	 * But it has at most 52 significant bits,
	 * so a 64-bit integer or double-precision float type are safe for storing this identifier.
	 *
	 * @return int
	 */
	public function getId(): int
	{
		return (int)$this->getAsArray()["id"] ?? 0;
	}

	/**
	 * True, if this user is a bot
	 *
	 * @return bool
	 */
	public function isBot(): bool
	{
		return ($this->getAsArray()["is_bot"] ?? false);
	}

	/**
	 * User's or bot's first name
	 *
	 * @return string
	 */
	public function getFirstName(): string
	{
		return (string)$this->getAsArray()["first_name"] ?? "";
	}

	/**
	 * Optional. User's or bot's last name
	 *
	 * @return string
	 */
	public function getLastName(): string
	{
		return (string)$this->getAsArray()["last_name"] ?? "";
	}

	/**
	 * Optional. User's or bot's username
	 *
	 * @return string
	 */
	public function getUsername(): string
	{
		return (string)$this->getAsArray()["username"] ?? "";
	}

	/**
	 * Optional. IETF language tag of the user's language
	 *
	 * @return string
	 */
	public function getLanguageCode(): string
	{
		return (string)$this->getAsArray()["language_code"] ?? "";
	}

	/**
	 * Optional. True, if this user is a Telegram Premium user
	 *
	 * @return bool
	 */
	public function isPremium(): bool
	{
		return ($this->getAsArray()["is_premium"] ?? false);
	}

	/**
	 * Optional. True, if this user added the bot to the attachment menu
	 *
	 * @return bool
	 */
	public function isAddedToAttachmentMenu(): bool
	{
		return ($this->getAsArray()["added_to_attachment_menu"] ?? false);
	}

	/**
	 * Optional. True, if the bot can be invited to groups.
	 * Returned only in getMe.
	 *
	 * @return bool
	 */
	public function canJoinGroups(): bool
	{
		return ($this->getAsArray()["can_join_groups"] ?? false);
	}

	/**
	 * Optional. True, if privacy mode is disabled for the bot.
	 * Returned only in getMe.
	 *
	 * @return bool
	 */
	public function canReadAllGroupMessages(): bool
	{
		return ($this->getAsArray()["can_read_all_group_messages"] ?? false);
	}

	/**
	 * Optional. True, if the bot supports inline queries.
	 * Returned only in getMe.
	 *
	 * @return bool
	 */
	public function supportsInlineQueries(): bool
	{
		return ($this->getAsArray()["supports_inline_queries"] ?? false);
	}

	/**
	 * Optional. True, if the bot can be connected to a Telegram Business account to receive its messages.
	 * Returned only in getMe.
	 *
	 * @return bool
	 */
	public function canConnectToBusiness(): bool
	{
		return ($this->getAsArray()["can_connect_to_business"] ?? false);
	}

	/**
	 * Optional. True, if the bot has a main Web App.
	 * Returned only in getMe.
	 *
	 * @return bool
	 */
	public function hasMainWebApp(): bool
	{
		return ($this->getAsArray()["has_main_web_app"] ?? false);
	}

}
