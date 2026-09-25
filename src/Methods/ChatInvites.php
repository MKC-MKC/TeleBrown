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

}
