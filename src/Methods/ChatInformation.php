<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects;

trait ChatInformation
{

	/**
	 * Получаем актуальную информацию о чате.
	 * При успешном выполнении возвращается объект ChatFullInfo.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя @username.
	 * @return Objects\ChatFullInfo
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#getchat
	 */
	public function getChat(
		int|string $chatId,
	): Objects\ChatFullInfo
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
			],
		);

		return new Objects\ChatFullInfo($response->getData());
	}

}
