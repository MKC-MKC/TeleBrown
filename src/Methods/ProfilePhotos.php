<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

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

	/**
	 * Изменяет фотографию профиля управляемого бизнес-аккаунта.
	 * Требуется право can_edit_profile_photo.
	 * При успешном выполнении возвращается True.
	 *
	 * @param string $businessConnectionId Идентификатор бизнес-подключения, от имени которого отправляется сообщение.
	 * @param Objects\InputProfilePhoto $photo Новая фотография профиля. В photo или animation передайте путь к новому локальному файлу.
	 * @param bool|null $isPublic Передайте True, чтобы установить публичную фотографию, видимую при скрытой основной фотографии.
	 * @return bool
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#setbusinessaccountprofilephoto
	 */
	public function setBusinessAccountProfilePhoto(
		string                    $businessConnectionId,
		Objects\InputProfilePhoto $photo,
		bool|null                 $isPublic = null,
	): bool
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"business_connection_id" => $businessConnectionId,
				"photo" => $photo->getAsArray(),
				"is_public" => $isPublic,
			],
			headers: ["Content-Type" => "multipart/form-data"],
		);

		return $response->isSuccess();
	}

}
