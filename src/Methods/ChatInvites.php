<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects;

trait ChatInvites
{

	/**
	 * Создаём новую основную пригласительную ссылку чата, отзывая предыдущую.
	 * Бот должен быть администратором с соответствующими правами.
	 * Боты могут использовать только собственные пригласительные ссылки.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя @username.
	 * @return string
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#exportchatinvitelink
	 */
	public function exportChatInviteLink(
		int|string $chatId,
	): string
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
			],
		);

		return $response->getData();
	}

	/**
	 * Одобряем заявку на вступление в чат.
	 * Боту требуется право администратора can_invite_users.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя @username.
	 * @param int $userId Уникальный идентификатор пользователя, например 123456789.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#approvechatjoinrequest
	 */
	public function approveChatJoinRequest(
		int|string $chatId,
		int        $userId,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"user_id" => $userId,
			],
		)->isSuccess();
	}

}
