<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects;

trait BotSettings
{

	/**
	 * Изменяем имя бота.
	 *
	 * @param string|null $name Новое имя бота, 0-64 символа. Пустая строка удаляет имя для указанного языка.
	 * @param string|null $languageCode Двухбуквенный код языка ISO 639-1, например ru. Пустая строка задаёт значение для остальных языков.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#setmyname
	 */
	public function setMyName(
		string|null $name = null,
		string|null $languageCode = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"name" => $name,
				"language_code" => $languageCode,
			],
		)->isSuccess();
	}

	/**
	 * Получаем текущее имя бота для указанного языка.
	 *
	 * @param string|null $languageCode Двухбуквенный код языка ISO 639-1, например ru. Пустая строка задаёт значение для остальных языков.
	 * @return Objects\BotName
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#getmyname
	 */
	public function getMyName(
		string|null $languageCode = null,
	): Objects\BotName
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"language_code" => $languageCode,
			],
		);

		return new Objects\BotName($response->getData());
	}

	/**
	 * Изменяем описание бота, отображаемое в пустом чате с ботом.
	 *
	 * @param string|null $description Новое описание бота, 0-512 символов. Пустая строка удаляет описание для указанного языка.
	 * @param string|null $languageCode Двухбуквенный код языка ISO 639-1, например ru. Пустая строка задаёт значение для остальных языков.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#setmydescription
	 */
	public function setMyDescription(
		string|null $description = null,
		string|null $languageCode = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"description" => $description,
				"language_code" => $languageCode,
			],
		)->isSuccess();
	}

	/**
	 * Получаем текущее описание бота для указанного языка.
	 *
	 * @param string|null $languageCode Двухбуквенный код языка ISO 639-1, например ru. Пустая строка задаёт значение для остальных языков.
	 * @return Objects\BotDescription
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#getmydescription
	 */
	public function getMyDescription(
		string|null $languageCode = null,
	): Objects\BotDescription
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"language_code" => $languageCode,
			],
		);

		return new Objects\BotDescription($response->getData());
	}

	/**
	 * Изменяем краткое описание бота в профиле и при отправке ссылки на бота.
	 *
	 * @param string|null $shortDescription Новое краткое описание, 0-120 символов. Пустая строка удаляет описание для указанного языка.
	 * @param string|null $languageCode Двухбуквенный код языка ISO 639-1, например ru. Пустая строка задаёт значение для остальных языков.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#setmyshortdescription
	 */
	public function setMyShortDescription(
		string|null $shortDescription = null,
		string|null $languageCode = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"short_description" => $shortDescription,
				"language_code" => $languageCode,
			],
		)->isSuccess();
	}

	/**
	 * Получаем текущее краткое описание бота для указанного языка.
	 *
	 * @param string|null $languageCode Двухбуквенный код языка ISO 639-1, например ru. Пустая строка задаёт значение для остальных языков.
	 * @return Objects\BotShortDescription
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#getmyshortdescription
	 */
	public function getMyShortDescription(
		string|null $languageCode = null,
	): Objects\BotShortDescription
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"language_code" => $languageCode,
			],
		);

		return new Objects\BotShortDescription($response->getData());
	}

	/**
	 * Удаляем фотографию профиля бота.
	 *
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#removemyprofilephoto
	 */
	public function removeMyProfilePhoto(): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
		)->isSuccess();
	}

	/**
	 * Подтверждаем пользователя от имени организации, которую представляет бот.
	 *
	 * @param int $userId Уникальный идентификатор пользователя.
	 * @param string|null $customDescription Описание проверки, 0-70 символов. Должно быть пустым, если организации не разрешено собственное описание.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#verifyuser
	 */
	public function verifyUser(
		int $userId,
		string|null $customDescription = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"user_id" => $userId,
				"custom_description" => $customDescription,
			],
		)->isSuccess();
	}

	/**
	 * Подтверждаем чат от имени организации, которую представляет бот.
	 * Чаты личных сообщений каналов не могут быть подтверждены.
	 *
	 * @param int|string $chatId Идентификатор чата или @username бота, супергруппы или канала.
	 * @param string|null $customDescription Описание проверки, 0-70 символов. Должно быть пустым, если организации не разрешено собственное описание.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#verifychat
	 */
	public function verifyChat(
		int|string $chatId,
		string|null $customDescription = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"custom_description" => $customDescription,
			],
		)->isSuccess();
	}

	/**
	 * Снимаем подтверждение пользователя от имени организации, которую представляет бот.
	 *
	 * @param int $userId Уникальный идентификатор пользователя.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#removeuserverification
	 */
	public function removeUserVerification(
		int $userId,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"user_id" => $userId,
			],
		)->isSuccess();
	}

	/**
	 * Снимаем подтверждение чата от имени организации, которую представляет бот.
	 *
	 * @param int|string $chatId Идентификатор чата или @username бота или канала.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#removechatverification
	 */
	public function removeChatVerification(
		int|string $chatId,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
			],
		)->isSuccess();
	}

}
