<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects;

trait BusinessAccounts
{

	/**
	 * Отмечаем входящее сообщение прочитанным от имени бизнес-аккаунта.
	 * Требуется право can_read_messages. Чат должен быть активен в последние 24 часа.
	 *
	 * @param string $businessConnectionId Уникальный идентификатор бизнес-подключения.
	 * @param int $chatId Уникальный идентификатор чата.
	 * @param int $messageId Идентификатор сообщения, которое нужно отметить прочитанным.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#readbusinessmessage
	 */
	public function readBusinessMessage(
		string $businessConnectionId,
		int $chatId,
		int $messageId,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"business_connection_id" => $businessConnectionId,
				"chat_id" => $chatId,
				"message_id" => $messageId,
			],
		)->isSuccess();
	}

	/**
	 * Удаляем сообщения от имени бизнес-аккаунта.
	 * Требуется can_delete_sent_messages для своих сообщений или can_delete_all_messages для любых.
	 *
	 * @param string $businessConnectionId Уникальный идентификатор бизнес-подключения.
	 * @param int[] $messageIds От 1 до 100 идентификаторов сообщений из одного чата. Ограничения удаления описаны в deleteMessage.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#deletebusinessmessages
	 */
	public function deleteBusinessMessages(
		string $businessConnectionId,
		array $messageIds,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"business_connection_id" => $businessConnectionId,
				"message_ids" => $messageIds,
			],
		)->isSuccess();
	}

	/**
	 * Изменяем имя и фамилию управляемого бизнес-аккаунта. Требуется право can_change_name.
	 *
	 * @param string $businessConnectionId Уникальный идентификатор бизнес-подключения.
	 * @param string $firstName Новое имя бизнес-аккаунта, 1-64 символа.
	 * @param string|null $lastName Новая фамилия бизнес-аккаунта, 0-64 символа.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#setbusinessaccountname
	 */
	public function setBusinessAccountName(
		string $businessConnectionId,
		string $firstName,
		string|null $lastName = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"business_connection_id" => $businessConnectionId,
				"first_name" => $firstName,
				"last_name" => $lastName,
			],
		)->isSuccess();
	}

	/**
	 * Изменяем имя пользователя управляемого бизнес-аккаунта. Требуется право can_change_username.
	 *
	 * @param string $businessConnectionId Уникальный идентификатор бизнес-подключения.
	 * @param string|null $username Новое имя пользователя бизнес-аккаунта, 0-32 символа.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#setbusinessaccountusername
	 */
	public function setBusinessAccountUsername(
		string $businessConnectionId,
		string|null $username = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"business_connection_id" => $businessConnectionId,
				"username" => $username,
			],
		)->isSuccess();
	}

}
