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

	/**
	 * Копирует сообщение любого типа, кроме служебных сообщений, платных медиа, розыгрышей,
	 * сообщений с победителями розыгрыша и счетов. Копия не содержит ссылки на оригинал.
	 * Возвращается идентификатор скопированного сообщения MessageId.
	 *
	 * @param int|string $chatId Идентификатор целевого чата или его @username.
	 * @param int|string $fromChatId Идентификатор исходного чата или его @username.
	 * @param int $messageId Идентификатор исходного сообщения.
	 * @param int|null $messageThreadId Идентификатор темы форума; для супергрупп и личных чатов ботов с включённым режимом тем.
	 * @param int|null $directMessagesTopicId Идентификатор темы личных сообщений канала; обязателен для чатов личных сообщений каналов.
	 * @param int|null $videoStartTimestamp Новая начальная отметка времени скопированного видео.
	 * @param string|null $caption Подпись к медиа, от 0 до 1024 символов после разбора сущностей.
	 * @param Enums\ParseModeEnum|null $parseMode Режим разбора сущностей в подписи.
	 * @param Objects\MessageEntity[]|array|null $captionEntities Сущности подписи; можно указать вместо parse_mode.
	 * @param bool|null $showCaptionAboveMedia Передайте True, чтобы показать подпись над медиа.
	 * @param bool|null $disableNotification Отправка без звука уведомления.
	 * @param bool|null $protectContent Защищает содержимое от пересылки и сохранения.
	 * @param bool|null $allowPaidBroadcast Разрешает до 1000 сообщений в секунду за 0,1 звезды Telegram за сообщение.
	 * @param string|null $messageEffectId Идентификатор эффекта сообщения; только для личных чатов.
	 * @param Objects\SuggestedPostParameters|null $suggestedPostParameters Параметры предлагаемой публикации; только для чатов личных сообщений каналов.
	 * @param Objects\ReplyParameters|null $replyParameters Описание сообщения, на которое отправляется ответ.
	 * @param Objects\InlineKeyboardMarkup|Objects\ReplyKeyboardMarkup|Objects\ReplyKeyboardRemove|Objects\ForceReply|null $replyMarkup Inline-клавиатура, клавиатура ответа, её удаление или запрос ответа.
	 * @return Objects\MessageId
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#copymessage
	 */
	public function copyMessage(
		int|string                                                                                                   $chatId,
		int|string                                                                                                   $fromChatId,
		int                                                                                                          $messageId,
		int|null                                                                                                     $messageThreadId = null,
		int|null                                                                                                     $directMessagesTopicId = null,
		int|null                                                                                                     $videoStartTimestamp = null,
		string|null                                                                                                  $caption = null,
		Enums\ParseModeEnum|null                                                                                     $parseMode = null,
		array|null                                                                                                   $captionEntities = null,
		bool|null                                                                                                    $showCaptionAboveMedia = null,
		bool|null                                                                                                    $disableNotification = null,
		bool|null                                                                                                    $protectContent = null,
		bool|null                                                                                                    $allowPaidBroadcast = null,
		string|null                                                                                                  $messageEffectId = null,
		Objects\SuggestedPostParameters|null                                                                         $suggestedPostParameters = null,
		Objects\ReplyParameters|null                                                                                 $replyParameters = null,
		Objects\InlineKeyboardMarkup|Objects\ReplyKeyboardMarkup|Objects\ReplyKeyboardRemove|Objects\ForceReply|null $replyMarkup = null,
	): Objects\MessageId
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"from_chat_id" => $fromChatId,
				"message_id" => $messageId,
				"message_thread_id" => $messageThreadId,
				"direct_messages_topic_id" => $directMessagesTopicId,
				"video_start_timestamp" => $videoStartTimestamp,
				"caption" => $caption,
				"parse_mode" => $parseMode?->value,
				"caption_entities" => $captionEntities,
				"show_caption_above_media" => $showCaptionAboveMedia,
				"disable_notification" => $disableNotification,
				"protect_content" => $protectContent,
				"allow_paid_broadcast" => $allowPaidBroadcast,
				"message_effect_id" => $messageEffectId,
				"suggested_post_parameters" => $suggestedPostParameters?->getAsArray(),
				"reply_parameters" => $replyParameters?->getAsArray(),
				"reply_markup" => $replyMarkup?->getAsArray(),
			],
		);

		return new Objects\MessageId($response->getData());
	}

}
