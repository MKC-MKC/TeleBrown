<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects;

trait ManagedBots
{

	/**
	 * Получаем токен управляемого бота.
	 *
	 * @param int $userId Идентификатор управляемого бота.
	 * @return string
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#getmanagedbottoken
	 */
	public function getManagedBotToken(
		int $userId,
	): string
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"user_id" => $userId,
			],
		);

		return (string)$response->getData();
	}

	/**
	 * Отзываем текущий токен управляемого бота и создаём новый.
	 *
	 * @param int $userId Идентификатор управляемого бота.
	 * @return string
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#replacemanagedbottoken
	 */
	public function replaceManagedBotToken(
		int $userId,
	): string
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"user_id" => $userId,
			],
		);

		return (string)$response->getData();
	}

	/**
	 * Изменяем настройки доступа к управляемому боту.
	 *
	 * @param int $userId Идентификатор управляемого бота.
	 * @param bool $isAccessRestricted True, если доступ разрешён только выбранным пользователям. Владелец всегда имеет доступ.
	 * @param int[]|null $addedUserIds До 10 идентификаторов пользователей с доступом помимо владельца. Игнорируется при is_access_restricted = false.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#setmanagedbotaccesssettings
	 */
	public function setManagedBotAccessSettings(
		int $userId,
		bool $isAccessRestricted,
		array|null $addedUserIds = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"user_id" => $userId,
				"is_access_restricted" => $isAccessRestricted,
				"added_user_ids" => $addedUserIds,
			],
		)->isSuccess();
	}

	/**
	 * Получаем настройки доступа к управляемому боту.
	 *
	 * @param int $userId Идентификатор управляемого бота.
	 * @return Objects\BotAccessSettings
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#getmanagedbotaccesssettings
	 */
	public function getManagedBotAccessSettings(
		int $userId,
	): Objects\BotAccessSettings
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"user_id" => $userId,
			],
		);

		return new Objects\BotAccessSettings($response->getData());
	}

}
