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

}
