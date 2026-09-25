<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects;

trait ManagedBots
{

	/**
	 * Получаем токен управляемого бота.
	 *
	 * @param int $userId Идентификатор управляемого бота.
	 * @return string
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#getmanagedbottoken
	 */
	public function getManagedBotToken(
		int $userId,
	): string
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"user_id" => $userId,
			],
		);

		return (string)$response->getData();
	}

}
