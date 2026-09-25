<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects;

trait BotSettings
{

	/**
	 * Изменяем имя бота.
	 *
	 * @param string|null $name Новое имя бота, 0-64 символа. Пустая строка удаляет имя для указанного языка.
	 * @param string|null $languageCode Двухбуквенный код языка ISO 639-1, например ru. Пустая строка задаёт значение для остальных языков.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#setmyname
	 */
	public function setMyName(
		string|null $name = null,
		string|null $languageCode = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"name" => $name,
				"language_code" => $languageCode,
			],
		)->isSuccess();
	}

}
