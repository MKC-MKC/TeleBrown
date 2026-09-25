<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Exceptions\TelegramMainException;

trait ChatSettings
{

	/**
	 * Удаляем фотографию чата. В личных чатах фотографию изменить нельзя.
	 * Бот должен быть администратором с соответствующими правами.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя @username.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#deletechatphoto
	 */
	public function deleteChatPhoto(
		int|string $chatId,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
			],
		)->isSuccess();
	}

	/**
	 * Изменяем название чата. Названия личных чатов изменить нельзя.
	 * Бот должен быть администратором с соответствующими правами.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя @username.
	 * @param string $title Новое название чата, от 1 до 128 символов.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#setchattitle
	 */
	public function setChatTitle(
		int|string $chatId,
		string     $title,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"title" => $title,
			],
		)->isSuccess();
	}

}
