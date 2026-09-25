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

	/**
	 * Изменяем права администратора, запрашиваемые ботом по умолчанию при добавлении в группы или каналы.
	 * Пользователь может изменить предложенные права перед добавлением бота.
	 *
	 * @param Objects\ChatAdministratorRights|null $rights Новые права администратора по умолчанию. Если не указаны, права по умолчанию будут очищены.
	 * @param bool|null $forChannels True для каналов. Иначе используются группы и супергруппы.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#setmydefaultadministratorrights
	 */
	public function setMyDefaultAdministratorRights(
		Objects\ChatAdministratorRights|null $rights = null,
		bool|null $forChannels = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"rights" => $rights?->getAsArray(),
				"for_channels" => $forChannels,
			],
		)->isSuccess();
	}

	/**
	 * Получаем текущие права администратора бота по умолчанию.
	 *
	 * @param bool|null $forChannels True для каналов. Иначе используются группы и супергруппы.
	 * @return Objects\ChatAdministratorRights
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#getmydefaultadministratorrights
	 */
	public function getMyDefaultAdministratorRights(
		bool|null $forChannels = null,
	): Objects\ChatAdministratorRights
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"for_channels" => $forChannels,
			],
		);

		return new Objects\ChatAdministratorRights($response->getData());
	}

	/**
	 * Удаляем команды бота для указанной области и языка.
	 * После удаления пользователям будут показаны команды более высокого уровня.
	 *
	 * @param Objects\BotCommandScope|null $scope Область действия команд. По умолчанию BotCommandScopeDefault.
	 * @param string|null $languageCode Двухбуквенный код языка ISO 639-1, например ru. Пустая строка задаёт значение для остальных языков.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#deletemycommands
	 */
	public function deleteMyCommands(
		Objects\BotCommandScope|null $scope = null,
		string|null $languageCode = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"scope" => $scope?->getAsArray(),
				"language_code" => $languageCode,
			],
		)->isSuccess();
	}

	/**
	 * Получаем команды бота для указанной области и языка. Если команды не заданы, возвращаем пустой список.
	 *
	 * @param Objects\BotCommandScope|null $scope Область действия команд. По умолчанию BotCommandScopeDefault.
	 * @param string|null $languageCode Двухбуквенный код языка ISO 639-1, например ru. Пустая строка задаёт значение для остальных языков.
	 * @return Objects\BotCommand[]
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#getmycommands
	 */
	public function getMyCommands(
		Objects\BotCommandScope|null $scope = null,
		string|null $languageCode = null,
	): array
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"scope" => $scope?->getAsArray(),
				"language_code" => $languageCode,
			],
		);

		return array_map(static fn(array $item): Objects\BotCommand => new Objects\BotCommand($item), $response->getData());
	}

	/**
	 * Изменяем список команд бота.
	 *
	 * @param Objects\BotCommand[]|array[] $commands Список команд бота, не более 100 команд.
	 * @param Objects\BotCommandScope|null $scope Область действия команд. По умолчанию BotCommandScopeDefault.
	 * @param string|null $languageCode Двухбуквенный код языка ISO 639-1, например ru. Пустая строка задаёт значение для остальных языков.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#setmycommands
	 */
	public function setMyCommands(
		array $commands,
		Objects\BotCommandScope|null $scope = null,
		string|null $languageCode = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"commands" => $commands,
				"scope" => $scope?->getAsArray(),
				"language_code" => $languageCode,
			],
		)->isSuccess();
	}

	/**
	 * Получаем кнопку меню бота в личном чате или кнопку меню по умолчанию.
	 *
	 * @param int|null $chatId Идентификатор личного чата. Если не указан, используется кнопка меню по умолчанию.
	 * @return Objects\MenuButton
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#getchatmenubutton
	 */
	public function getChatMenuButton(
		int|null $chatId = null,
	): Objects\MenuButton
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
			],
		);

		return new Objects\MenuButton($response->getData());
	}

	/**
	 * Изменяем кнопку меню бота в личном чате или кнопку меню по умолчанию.
	 *
	 * @param int|null $chatId Идентификатор личного чата. Если не указан, используется кнопка меню по умолчанию.
	 * @param Objects\MenuButton|null $menuButton Новая кнопка меню. По умолчанию MenuButtonDefault.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#setchatmenubutton
	 */
	public function setChatMenuButton(
		int|null $chatId = null,
		Objects\MenuButton|null $menuButton = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"menu_button" => $menuButton?->getAsArray(),
			],
		)->isSuccess();
	}

}
