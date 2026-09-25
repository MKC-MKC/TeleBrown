<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects;

trait ForumTopics
{

	/**
	 * Получаем стикеры с доступными значками тем. Возвращаем массив объектов Sticker.
	 *
	 * @return Objects\Sticker[]
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#getforumtopiciconstickers
	 */
	public function getForumTopicIconStickers(): array
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
		);

		return array_map(static fn(array $item): Objects\Sticker => new Objects\Sticker($item), $response->getData());
	}

	/**
	 * Создаём тему в супергруппе с темами или личном чате. Возвращаем объект ForumTopic.
	 * В супергруппе бот должен быть администратором с правом can_manage_topics.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя супергруппы @username.
	 * @param string $name Название темы, от 1 до 128 символов.
	 * @param int|null $iconColor Цвет RGB: 7322096, 16766590, 13338331, 9367192, 16749490 или 16478047.
	 * @param string|null $iconCustomEmojiId ID значка из getForumTopicIconStickers, например 5368324170671202286.
	 * @return Objects\ForumTopic
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#createforumtopic
	 */
	public function createForumTopic(
		int|string  $chatId,
		string      $name,
		int|null    $iconColor = null,
		string|null $iconCustomEmojiId = null,
	): Objects\ForumTopic
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"name" => $name,
				"icon_color" => $iconColor,
				"icon_custom_emoji_id" => $iconCustomEmojiId,
			]
		);

		return new Objects\ForumTopic($response->getData());
	}

	/**
	 * Изменяем название и значок темы в супергруппе или личном чате.
	 * В супергруппе бот должен быть администратором с правом can_manage_topics. Для создателя темы это не требуется.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя супергруппы @username.
	 * @param int $messageThreadId Идентификатор темы, например 42.
	 * @param string|null $name Название, 0-128 символов. null или пустая строка сохраняют текущее название.
	 * @param string|null $iconCustomEmojiId ID нового значка. Пустая строка удаляет значок, null сохраняет текущий.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#editforumtopic
	 */
	public function editForumTopic(
		int|string  $chatId,
		int         $messageThreadId,
		string|null $name = null,
		string|null $iconCustomEmojiId = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"message_thread_id" => $messageThreadId,
				"name" => $name,
				"icon_custom_emoji_id" => $iconCustomEmojiId,
			]
		)->isSuccess();
	}

	/**
	 * Закрываем открытую тему в супергруппе.
	 * В супергруппе бот должен быть администратором с правом can_manage_topics. Для создателя темы это не требуется.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя супергруппы @username.
	 * @param int $messageThreadId Идентификатор темы, например 42.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#closeforumtopic
	 */
	public function closeForumTopic(
		int|string $chatId,
		int        $messageThreadId,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"message_thread_id" => $messageThreadId,
			]
		)->isSuccess();
	}

	/**
	 * Открываем закрытую тему в супергруппе.
	 * В супергруппе бот должен быть администратором с правом can_manage_topics. Для создателя темы это не требуется.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя супергруппы @username.
	 * @param int $messageThreadId Идентификатор темы, например 42.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#reopenforumtopic
	 */
	public function reopenForumTopic(
		int|string $chatId,
		int        $messageThreadId,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"message_thread_id" => $messageThreadId,
			]
		)->isSuccess();
	}

	/**
	 * Удаляем тему вместе со всеми сообщениями в супергруппе или личном чате.
	 * В супергруппе бот должен быть администратором с правом can_delete_messages.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя супергруппы @username.
	 * @param int $messageThreadId Идентификатор темы, например 42.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#deleteforumtopic
	 */
	public function deleteForumTopic(
		int|string $chatId,
		int        $messageThreadId,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"message_thread_id" => $messageThreadId,
			]
		)->isSuccess();
	}

	/**
	 * Открепляем все сообщения темы в супергруппе или личном чате.
	 * В супергруппе бот должен быть администратором с правом can_pin_messages.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя супергруппы @username.
	 * @param int $messageThreadId Идентификатор темы, например 42.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#unpinallforumtopicmessages
	 */
	public function unpinAllForumTopicMessages(
		int|string $chatId,
		int        $messageThreadId,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"message_thread_id" => $messageThreadId,
			]
		)->isSuccess();
	}

	/**
	 * Изменяем название общей темы в супергруппе.
	 * В супергруппе бот должен быть администратором с правом can_manage_topics.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя супергруппы @username.
	 * @param string $name Название темы, от 1 до 128 символов.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#editgeneralforumtopic
	 */
	public function editGeneralForumTopic(
		int|string $chatId,
		string     $name,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"name" => $name,
			]
		)->isSuccess();
	}

	/**
	 * Закрываем общую тему в супергруппе.
	 * В супергруппе бот должен быть администратором с правом can_manage_topics.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя супергруппы @username.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#closegeneralforumtopic
	 */
	public function closeGeneralForumTopic(int|string $chatId): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
			]
		)->isSuccess();
	}

	/**
	 * Открываем общую тему в супергруппе. Скрытая тема автоматически становится видимой.
	 * В супергруппе бот должен быть администратором с правом can_manage_topics.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя супергруппы @username.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#reopengeneralforumtopic
	 */
	public function reopenGeneralForumTopic(int|string $chatId): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
			]
		)->isSuccess();
	}

	/**
	 * Скрываем общую тему в супергруппе. Открытая тема автоматически закрывается.
	 * В супергруппе бот должен быть администратором с правом can_manage_topics.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя супергруппы @username.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#hidegeneralforumtopic
	 */
	public function hideGeneralForumTopic(int|string $chatId): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
			]
		)->isSuccess();
	}

	/**
	 * Делаем общую тему в супергруппе видимой.
	 * В супергруппе бот должен быть администратором с правом can_manage_topics.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя супергруппы @username.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#unhidegeneralforumtopic
	 */
	public function unhideGeneralForumTopic(int|string $chatId): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
			]
		)->isSuccess();
	}

	/**
	 * Открепляем все сообщения общей темы в супергруппе.
	 * Бот должен быть администратором с правом can_pin_messages.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя супергруппы @username.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#unpinallgeneralforumtopicmessages
	 */
	public function unpinAllGeneralForumTopicMessages(int|string $chatId): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
			]
		)->isSuccess();
	}

}
