<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Exceptions\TelegramMainException;

trait MessageReactions
{

	/**
	 * Удаляем реакцию с сообщения в группе или супергруппе.
	 * Боту требуется право администратора can_delete_messages.
	 *
	 * @param int|string $chatId Идентификатор целевого чата или @username супергруппы.
	 * @param int $messageId Идентификатор целевого сообщения.
	 * @param int|null $userId Идентификатор пользователя, чьи реакции удаляются, если они добавлены пользователем.
	 * @param int|null $actorChatId Идентификатор чата, чьи реакции удаляются, если они добавлены от имени чата.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#deletemessagereaction
	 */
	public function deleteMessageReaction(
		int|string $chatId,
		int        $messageId,
		int|null   $userId = null,
		int|null   $actorChatId = null,
	): bool
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"message_id" => $messageId,
				"user_id" => $userId,
				"actor_chat_id" => $actorChatId,
			],
		);

		return $response->isSuccess();
	}

}
