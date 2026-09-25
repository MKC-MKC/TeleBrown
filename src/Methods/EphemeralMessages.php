<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Enums;
use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects;

trait EphemeralMessages
{

	/**
	 * Удаляем эфемерное сообщение.
	 * Доставка события удаления пользователю не гарантируется, особенно если он не в сети.
	 *
	 * @param int|string $chatId Идентификатор целевого чата или @username супергруппы.
	 * @param int $receiverUserId Идентификатор пользователя, получившего сообщение.
	 * @param int $ephemeralMessageId Идентификатор эфемерного сообщения.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#deleteephemeralmessage
	 */
	public function deleteEphemeralMessage(
		int|string $chatId,
		int        $receiverUserId,
		int        $ephemeralMessageId,
	): bool
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"receiver_user_id" => $receiverUserId,
				"ephemeral_message_id" => $ephemeralMessageId,
			],
		);

		return $response->isSuccess();
	}

}
