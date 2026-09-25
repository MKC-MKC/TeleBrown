<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Exceptions\TelegramMainException;

trait ChatSettings
{

	/**
	 * Удаляем фотографию чата. В личных чатах фотографию изменить нельзя.
	 * Бот должен быть администратором с соответствующими правами.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя @username.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#deletechatphoto
	 */
	public function deleteChatPhoto(
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
	 * Изменяем название чата. Названия личных чатов изменить нельзя.
	 * Бот должен быть администратором с соответствующими правами.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя @username.
	 * @param string $title Новое название чата, от 1 до 128 символов.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#setchattitle
	 */
	public function setChatTitle(
		int|string $chatId,
		string     $title,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"title" => $title,
			],
		)->isSuccess();
	}

	/**
	 * Изменяем описание группы, супергруппы или канала.
	 * Бот должен быть администратором с соответствующими правами.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя @username.
	 * @param string|null $description Новое описание чата, от 0 до 255 символов.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#setchatdescription
	 */
	public function setChatDescription(
		int|string  $chatId,
		string|null $description = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"description" => $description,
			],
		)->isSuccess();
	}

	/**
	 * Задаём метку обычному участнику группы или супергруппы.
	 * Боту требуется право администратора can_manage_tags.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя @username.
	 * @param int $userId Уникальный идентификатор пользователя, например 123456789.
	 * @param string|null $tag Метка участника, от 0 до 16 символов, без эмодзи.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#setchatmembertag
	 */
	public function setChatMemberTag(
		int|string  $chatId,
		int         $userId,
		string|null $tag = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"user_id" => $userId,
				"tag" => $tag,
			],
		)->isSuccess();
	}

	/**
	 * Открепляем все сообщения в чате.
	 * В группах требуется право can_pin_messages, в каналах - can_edit_messages.
	 * В личных чатах и чатах личных сообщений канала дополнительные права не требуются.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя @username.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#unpinallchatmessages
	 */
	public function unpinAllChatMessages(
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
	 * Открепляем сообщение в чате.
	 * В группах требуется право can_pin_messages, в каналах - can_edit_messages.
	 * В личных чатах и чатах личных сообщений канала можно открепить любое сообщение.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя @username.
	 * @param string|null $businessConnectionId Идентификатор бизнес-подключения, от имени которого выполняется действие.
	 * @param int|null $messageId Идентификатор сообщения, например 42. Обязателен при business_connection_id. Без него открепляется последнее закреплённое сообщение.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#unpinchatmessage
	 */
	public function unpinChatMessage(
		int|string  $chatId,
		string|null $businessConnectionId = null,
		int|null    $messageId = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"business_connection_id" => $businessConnectionId,
				"message_id" => $messageId,
			],
		)->isSuccess();
	}

}
