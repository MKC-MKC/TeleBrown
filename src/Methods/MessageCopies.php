<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Enums;
use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects;

trait MessageCopies
{

	/**
	 * Копирует сообщения любого типа, кроме служебных сообщений, платных медиа, розыгрышей,
	 * сообщений с победителями розыгрыша и счетов. Недоступные сообщения пропускаются.
	 * Группировка альбомов сохраняется. Возвращается массив идентификаторов MessageId.
	 *
	 * @param int|string $chatId Идентификатор целевого чата или его @username.
	 * @param int|string $fromChatId Идентификатор исходного чата или его @username.
	 * @param array $messageIds От 1 до 100 идентификаторов сообщений в строго возрастающем порядке.
	 * @param int|null $messageThreadId Идентификатор темы форума; для супергрупп и личных чатов ботов с включённым режимом тем.
	 * @param int|null $directMessagesTopicId Идентификатор темы личных сообщений канала; обязателен для чатов личных сообщений каналов.
	 * @param bool|null $disableNotification Отправка без звука уведомления.
	 * @param bool|null $protectContent Защищает содержимое от пересылки и сохранения.
	 * @param bool|null $removeCaption Передайте True, чтобы скопировать сообщения без подписей.
	 * @return Objects\MessageId[]
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#copymessages
	 */
	public function copyMessages(
		int|string $chatId,
		int|string $fromChatId,
		array      $messageIds,
		int|null   $messageThreadId = null,
		int|null   $directMessagesTopicId = null,
		bool|null  $disableNotification = null,
		bool|null  $protectContent = null,
		bool|null  $removeCaption = null,
	): array
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"from_chat_id" => $fromChatId,
				"message_ids" => $messageIds,
				"message_thread_id" => $messageThreadId,
				"direct_messages_topic_id" => $directMessagesTopicId,
				"disable_notification" => $disableNotification,
				"protect_content" => $protectContent,
				"remove_caption" => $removeCaption,
			],
		);

		return array_map(static fn(array $item): Objects\MessageId => new Objects\MessageId($item), $response->getData());
	}

}
