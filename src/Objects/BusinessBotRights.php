<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class BusinessBotRights extends ResponseWrapper
{

	/**
	 * Необязательно. True, если бот может отправлять и редактировать сообщения в личных чатах, где за последние 24 часа были входящие сообщения.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#businessbotrights
	 */
	public function canReply(): bool
	{
		return (bool)$this->getData("can_reply");
	}

	/**
	 * Необязательно. True, если бот может отмечать входящие личные сообщения прочитанными.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#businessbotrights
	 */
	public function canReadMessages(): bool
	{
		return (bool)$this->getData("can_read_messages");
	}

	/**
	 * Необязательно. True, если бот может удалять отправленные им сообщения.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#businessbotrights
	 */
	public function canDeleteSentMessages(): bool
	{
		return (bool)$this->getData("can_delete_sent_messages");
	}

	/**
	 * Необязательно. True, если бот может удалять все личные сообщения в управляемых чатах.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#businessbotrights
	 */
	public function canDeleteAllMessages(): bool
	{
		return (bool)$this->getData("can_delete_all_messages");
	}

	/**
	 * Необязательно. True, если бот может менять имя и фамилию бизнес-аккаунта.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#businessbotrights
	 */
	public function canEditName(): bool
	{
		return (bool)$this->getData("can_edit_name");
	}

	/**
	 * Необязательно. True, если бот может менять описание бизнес-аккаунта.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#businessbotrights
	 */
	public function canEditBio(): bool
	{
		return (bool)$this->getData("can_edit_bio");
	}

	/**
	 * Необязательно. True, если бот может менять фотографию бизнес-аккаунта.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#businessbotrights
	 */
	public function canEditProfilePhoto(): bool
	{
		return (bool)$this->getData("can_edit_profile_photo");
	}

	/**
	 * Необязательно. True, если бот может менять имя пользователя бизнес-аккаунта.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#businessbotrights
	 */
	public function canEditUsername(): bool
	{
		return (bool)$this->getData("can_edit_username");
	}

	/**
	 * Необязательно. True, если бот может менять настройки конфиденциальности подарков бизнес-аккаунта.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#businessbotrights
	 */
	public function canChangeGiftSettings(): bool
	{
		return (bool)$this->getData("can_change_gift_settings");
	}

	/**
	 * Необязательно. True, если бот может просматривать подарки и количество Telegram Stars бизнес-аккаунта.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#businessbotrights
	 */
	public function canViewGiftsAndStars(): bool
	{
		return (bool)$this->getData("can_view_gifts_and_stars");
	}

	/**
	 * Необязательно. True, если бот может преобразовывать обычные подарки бизнес-аккаунта в Telegram Stars.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#businessbotrights
	 */
	public function canConvertGiftsToStars(): bool
	{
		return (bool)$this->getData("can_convert_gifts_to_stars");
	}

	/**
	 * Необязательно. True, если бот может передавать и улучшать подарки бизнес-аккаунта.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#businessbotrights
	 */
	public function canTransferAndUpgradeGifts(): bool
	{
		return (bool)$this->getData("can_transfer_and_upgrade_gifts");
	}

	/**
	 * Необязательно. True, если бот может переводить Telegram Stars бизнес-аккаунта себе или использовать их для улучшения и передачи подарков.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#businessbotrights
	 */
	public function canTransferStars(): bool
	{
		return (bool)$this->getData("can_transfer_stars");
	}

	/**
	 * Необязательно. True, если бот может публиковать, редактировать и удалять истории от имени бизнес-аккаунта.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#businessbotrights
	 */
	public function canManageStories(): bool
	{
		return (bool)$this->getData("can_manage_stories");
	}

}
