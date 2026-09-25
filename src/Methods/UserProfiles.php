<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Enums;
use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects;

trait UserProfiles
{

	/**
	 * Используйте этот метод, чтобы изменить статус эмодзи пользователя.
	 * Пользователь должен разрешить боту изменять статус через Mini App.
	 * При успешном выполнении возвращается True.
	 *
	 * @param int $userId Уникальный идентификатор пользователя.
	 * @param string|null $emojiStatusCustomEmojiId Идентификатор пользовательского эмодзи для статуса. Пустая строка удаляет статус.
	 * @param int|null $emojiStatusExpirationDate Время окончания действия статуса в формате Unix.
	 * @return bool
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#setuseremojistatus
	 */
	public function setUserEmojiStatus(
		int         $userId,
		string|null $emojiStatusCustomEmojiId = null,
		int|null    $emojiStatusExpirationDate = null,
	): bool
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"user_id" => $userId,
				"emoji_status_custom_emoji_id" => $emojiStatusCustomEmojiId,
				"emoji_status_expiration_date" => $emojiStatusExpirationDate,
			],
		);

		return $response->isSuccess();
	}

}
