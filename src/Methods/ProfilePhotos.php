<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Enums;
use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects;

trait ProfilePhotos
{

	/**
	 * Изменяет фотографию профиля бота.
	 * При успешном выполнении возвращается True.
	 *
	 * @param Objects\InputProfilePhoto $photo Новая фотография профиля. В photo или animation передайте путь к новому локальному файлу.
	 * @return bool
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#setmyprofilephoto
	 */
	public function setMyProfilePhoto(
		Objects\InputProfilePhoto $photo,
	): bool
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"photo" => $photo->getAsArray(),
			],
			headers: ["Content-Type" => "multipart/form-data"],
		);

		return $response->isSuccess();
	}

}
