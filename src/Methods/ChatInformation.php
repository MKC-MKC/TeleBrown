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

	/**
	 * Получаем информацию об участнике чата.
	 * Работа метода для других пользователей гарантируется, только если бот является администратором.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя @username.
	 * @param int $userId Уникальный идентификатор пользователя, например 123456789.
	 * @return Objects\ChatMember
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#getchatmember
	 */
	public function getChatMember(
		int|string $chatId,
		int        $userId,
	): Objects\ChatMember
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"user_id" => $userId,
			],
		);

		return Objects\ChatMember::getChatMember($response->getData());
	}

	/**
	 * Получаем список администраторов чата.
	 * Возвращается массив объектов ChatMember.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя @username.
	 * @param bool|null $returnBots true, чтобы включить всех ботов-администраторов. По умолчанию другие боты исключаются.
	 * @return Objects\ChatMember[]
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#getchatadministrators
	 */
	public function getChatAdministrators(
		int|string $chatId,
		bool|null  $returnBots = null,
	): array
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"return_bots" => $returnBots,
			],
		);

		return array_map(static fn(array $item): Objects\ChatMember => Objects\ChatMember::getChatMember($item), $response->getData());
	}

}
