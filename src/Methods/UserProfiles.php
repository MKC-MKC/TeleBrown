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

	/**
	 * Используйте этот метод, чтобы получить последние сообщения из чата, указанного в профиле пользователя.
	 * Возвращается массив объектов Message.
	 *
	 * @param int $userId Уникальный идентификатор пользователя.
	 * @param int $limit Максимальное количество возвращаемых сообщений, от 1 до 20.
	 * @return Objects\Message[]
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#getuserpersonalchatmessages
	 */
	public function getUserPersonalChatMessages(
		int $userId,
		int $limit,
	): array
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"user_id" => $userId,
				"limit" => $limit,
			],
		);

		return array_map(static fn(array $item): Objects\Message => new Objects\Message($item), $response->getData());
	}

	/**
	 * Используйте этот метод, чтобы получить фотографии профиля пользователя.
	 * Возвращается объект UserProfilePhotos.
	 *
	 * @param int $userId Уникальный идентификатор пользователя.
	 * @param int|null $offset Смещение от начала списка.
	 * @param int|null $limit Количество фотографий, от 1 до 100. По умолчанию 100.
	 * @return Objects\UserProfilePhotos
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#getuserprofilephotos
	 */
	public function getUserProfilePhotos(
		int      $userId,
		int|null $offset = null,
		int|null $limit = null,
	): Objects\UserProfilePhotos
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"user_id" => $userId,
				"offset" => $offset,
				"limit" => $limit,
			],
		);

		return new Objects\UserProfilePhotos($response->getData());
	}

	/**
	 * Используйте этот метод, чтобы получить аудиофайлы профиля пользователя.
	 * Возвращается объект UserProfileAudios.
	 *
	 * @param int $userId Уникальный идентификатор пользователя.
	 * @param int|null $offset Смещение от начала списка.
	 * @param int|null $limit Количество аудиофайлов, от 1 до 100. По умолчанию 100.
	 * @return Objects\UserProfileAudios
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#getuserprofileaudios
	 */
	public function getUserProfileAudios(
		int      $userId,
		int|null $offset = null,
		int|null $limit = null,
	): Objects\UserProfileAudios
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"user_id" => $userId,
				"offset" => $offset,
				"limit" => $limit,
			],
		);

		return new Objects\UserProfileAudios($response->getData());
	}

}
