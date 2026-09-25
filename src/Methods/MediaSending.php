<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Enums;
use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects;

trait MediaSending
{

	/**
	 * Отправляет аудиофайл как голосовое сообщение. Поддерживаются OGG с OPUS, MP3 и M4A, до 50 МБ.
	 * Возвращается отправленное сообщение Message.
	 *
	 * @param int|string $chatId Идентификатор целевого чата или его @username.
	 * @param string $voice Голосовое сообщение: file_id, HTTP URL или путь к локальному файлу.
	 * @param string|null $businessConnectionId Идентификатор бизнес-подключения, от имени которого отправляется сообщение.
	 * @param int|null $messageThreadId Идентификатор темы форума; для супергрупп и личных чатов ботов с включённым режимом тем.
	 * @param int|null $directMessagesTopicId Идентификатор темы личных сообщений канала; обязателен для чатов личных сообщений каналов.
	 * @param Objects\EphemeralMessageParameters|null $ephemeralMessageParameters Параметры исчезающего сообщения.
	 * @param string|null $caption Подпись к медиа, от 0 до 1024 символов после разбора сущностей.
	 * @param Enums\ParseModeEnum|null $parseMode Режим разбора сущностей в подписи.
	 * @param Objects\MessageEntity[]|array|null $captionEntities Сущности подписи; можно указать вместо parse_mode.
	 * @param int|null $duration Продолжительность в секундах.
	 * @param bool|null $disableNotification Отправка без звука уведомления.
	 * @param bool|null $protectContent Защищает содержимое от пересылки и сохранения.
	 * @param bool|null $allowPaidBroadcast Разрешает до 1000 сообщений в секунду за 0,1 звезды Telegram за сообщение.
	 * @param string|null $messageEffectId Идентификатор эффекта сообщения; только для личных чатов.
	 * @param Objects\SuggestedPostParameters|null $suggestedPostParameters Параметры предлагаемой публикации; только для чатов личных сообщений каналов.
	 * @param Objects\ReplyParameters|null $replyParameters Описание сообщения, на которое отправляется ответ.
	 * @param Objects\InlineKeyboardMarkup|Objects\ReplyKeyboardMarkup|Objects\ReplyKeyboardRemove|Objects\ForceReply|null $replyMarkup Inline-клавиатура, клавиатура ответа, её удаление или запрос ответа.
	 * @return Objects\Message
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#sendvoice
	 */
	public function sendVoice(
		int|string                                                                                                   $chatId,
		string                                                                                                       $voice,
		string|null                                                                                                  $businessConnectionId = null,
		int|null                                                                                                     $messageThreadId = null,
		int|null                                                                                                     $directMessagesTopicId = null,
		Objects\EphemeralMessageParameters|null                                                                      $ephemeralMessageParameters = null,
		string|null                                                                                                  $caption = null,
		Enums\ParseModeEnum|null                                                                                     $parseMode = null,
		array|null                                                                                                   $captionEntities = null,
		int|null                                                                                                     $duration = null,
		bool|null                                                                                                    $disableNotification = null,
		bool|null                                                                                                    $protectContent = null,
		bool|null                                                                                                    $allowPaidBroadcast = null,
		string|null                                                                                                  $messageEffectId = null,
		Objects\SuggestedPostParameters|null                                                                         $suggestedPostParameters = null,
		Objects\ReplyParameters|null                                                                                 $replyParameters = null,
		Objects\InlineKeyboardMarkup|Objects\ReplyKeyboardMarkup|Objects\ReplyKeyboardRemove|Objects\ForceReply|null $replyMarkup = null,
	): Objects\Message
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"voice" => $voice,
				"business_connection_id" => $businessConnectionId,
				"message_thread_id" => $messageThreadId,
				"direct_messages_topic_id" => $directMessagesTopicId,
				"ephemeral_message_parameters" => $ephemeralMessageParameters?->getAsArray(),
				"caption" => $caption,
				"parse_mode" => $parseMode?->value,
				"caption_entities" => $captionEntities,
				"duration" => $duration,
				"disable_notification" => $disableNotification,
				"protect_content" => $protectContent,
				"allow_paid_broadcast" => $allowPaidBroadcast,
				"message_effect_id" => $messageEffectId,
				"suggested_post_parameters" => $suggestedPostParameters?->getAsArray(),
				"reply_parameters" => $replyParameters?->getAsArray(),
				"reply_markup" => $replyMarkup?->getAsArray(),
			],
			headers: ["Content-Type" => "multipart/form-data"],
		);

		return new Objects\Message($response->getData());
	}

	/**
	 * Отправляет аудиофайл для воспроизведения в музыкальном плеере. Поддерживаются MP3 и M4A, до 50 МБ.
	 * Возвращается отправленное сообщение Message.
	 *
	 * @param int|string $chatId Идентификатор целевого чата или его @username.
	 * @param string $audio Аудиофайл: file_id, HTTP URL или путь к локальному файлу.
	 * @param string|null $businessConnectionId Идентификатор бизнес-подключения, от имени которого отправляется сообщение.
	 * @param int|null $messageThreadId Идентификатор темы форума; для супергрупп и личных чатов ботов с включённым режимом тем.
	 * @param int|null $directMessagesTopicId Идентификатор темы личных сообщений канала; обязателен для чатов личных сообщений каналов.
	 * @param Objects\EphemeralMessageParameters|null $ephemeralMessageParameters Параметры исчезающего сообщения.
	 * @param string|null $caption Подпись к медиа, от 0 до 1024 символов после разбора сущностей.
	 * @param Enums\ParseModeEnum|null $parseMode Режим разбора сущностей в подписи.
	 * @param Objects\MessageEntity[]|array|null $captionEntities Сущности подписи; можно указать вместо parse_mode.
	 * @param int|null $duration Продолжительность в секундах.
	 * @param string|null $performer Исполнитель.
	 * @param string|null $title Название композиции.
	 * @param string|null $thumbnail Путь к новой миниатюре JPEG размером менее 200 КБ, шириной и высотой не более 320 пикселей.
	 * @param bool|null $disableNotification Отправка без звука уведомления.
	 * @param bool|null $protectContent Защищает содержимое от пересылки и сохранения.
	 * @param bool|null $allowPaidBroadcast Разрешает до 1000 сообщений в секунду за 0,1 звезды Telegram за сообщение.
	 * @param string|null $messageEffectId Идентификатор эффекта сообщения; только для личных чатов.
	 * @param Objects\SuggestedPostParameters|null $suggestedPostParameters Параметры предлагаемой публикации; только для чатов личных сообщений каналов.
	 * @param Objects\ReplyParameters|null $replyParameters Описание сообщения, на которое отправляется ответ.
	 * @param Objects\InlineKeyboardMarkup|Objects\ReplyKeyboardMarkup|Objects\ReplyKeyboardRemove|Objects\ForceReply|null $replyMarkup Inline-клавиатура, клавиатура ответа, её удаление или запрос ответа.
	 * @return Objects\Message
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#sendaudio
	 */
	public function sendAudio(
		int|string                                                                                                   $chatId,
		string                                                                                                       $audio,
		string|null                                                                                                  $businessConnectionId = null,
		int|null                                                                                                     $messageThreadId = null,
		int|null                                                                                                     $directMessagesTopicId = null,
		Objects\EphemeralMessageParameters|null                                                                      $ephemeralMessageParameters = null,
		string|null                                                                                                  $caption = null,
		Enums\ParseModeEnum|null                                                                                     $parseMode = null,
		array|null                                                                                                   $captionEntities = null,
		int|null                                                                                                     $duration = null,
		string|null                                                                                                  $performer = null,
		string|null                                                                                                  $title = null,
		string|null                                                                                                  $thumbnail = null,
		bool|null                                                                                                    $disableNotification = null,
		bool|null                                                                                                    $protectContent = null,
		bool|null                                                                                                    $allowPaidBroadcast = null,
		string|null                                                                                                  $messageEffectId = null,
		Objects\SuggestedPostParameters|null                                                                         $suggestedPostParameters = null,
		Objects\ReplyParameters|null                                                                                 $replyParameters = null,
		Objects\InlineKeyboardMarkup|Objects\ReplyKeyboardMarkup|Objects\ReplyKeyboardRemove|Objects\ForceReply|null $replyMarkup = null,
	): Objects\Message
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"audio" => $audio,
				"business_connection_id" => $businessConnectionId,
				"message_thread_id" => $messageThreadId,
				"direct_messages_topic_id" => $directMessagesTopicId,
				"ephemeral_message_parameters" => $ephemeralMessageParameters?->getAsArray(),
				"caption" => $caption,
				"parse_mode" => $parseMode?->value,
				"caption_entities" => $captionEntities,
				"duration" => $duration,
				"performer" => $performer,
				"title" => $title,
				"thumbnail" => $thumbnail,
				"disable_notification" => $disableNotification,
				"protect_content" => $protectContent,
				"allow_paid_broadcast" => $allowPaidBroadcast,
				"message_effect_id" => $messageEffectId,
				"suggested_post_parameters" => $suggestedPostParameters?->getAsArray(),
				"reply_parameters" => $replyParameters?->getAsArray(),
				"reply_markup" => $replyMarkup?->getAsArray(),
			],
			headers: ["Content-Type" => "multipart/form-data"],
		);

		return new Objects\Message($response->getData());
	}

	/**
	 * Отправляет GIF или видео H.264/MPEG-4 AVC без звука, до 50 МБ.
	 * Возвращается отправленное сообщение Message.
	 *
	 * @param int|string $chatId Идентификатор целевого чата или его @username.
	 * @param string $animation Анимация: file_id, HTTP URL или путь к локальному файлу.
	 * @param string|null $businessConnectionId Идентификатор бизнес-подключения, от имени которого отправляется сообщение.
	 * @param int|null $messageThreadId Идентификатор темы форума; для супергрупп и личных чатов ботов с включённым режимом тем.
	 * @param int|null $directMessagesTopicId Идентификатор темы личных сообщений канала; обязателен для чатов личных сообщений каналов.
	 * @param Objects\EphemeralMessageParameters|null $ephemeralMessageParameters Параметры исчезающего сообщения.
	 * @param int|null $duration Продолжительность в секундах.
	 * @param int|null $width Ширина в пикселях.
	 * @param int|null $height Высота в пикселях.
	 * @param string|null $thumbnail Путь к новой миниатюре JPEG размером менее 200 КБ, шириной и высотой не более 320 пикселей.
	 * @param string|null $caption Подпись к медиа, от 0 до 1024 символов после разбора сущностей.
	 * @param Enums\ParseModeEnum|null $parseMode Режим разбора сущностей в подписи.
	 * @param Objects\MessageEntity[]|array|null $captionEntities Сущности подписи; можно указать вместо parse_mode.
	 * @param bool|null $showCaptionAboveMedia Передайте True, чтобы показать подпись над медиа.
	 * @param bool|null $hasSpoiler Передайте True, чтобы скрыть медиа под спойлером.
	 * @param bool|null $disableNotification Отправка без звука уведомления.
	 * @param bool|null $protectContent Защищает содержимое от пересылки и сохранения.
	 * @param bool|null $allowPaidBroadcast Разрешает до 1000 сообщений в секунду за 0,1 звезды Telegram за сообщение.
	 * @param string|null $messageEffectId Идентификатор эффекта сообщения; только для личных чатов.
	 * @param Objects\SuggestedPostParameters|null $suggestedPostParameters Параметры предлагаемой публикации; только для чатов личных сообщений каналов.
	 * @param Objects\ReplyParameters|null $replyParameters Описание сообщения, на которое отправляется ответ.
	 * @param Objects\InlineKeyboardMarkup|Objects\ReplyKeyboardMarkup|Objects\ReplyKeyboardRemove|Objects\ForceReply|null $replyMarkup Inline-клавиатура, клавиатура ответа, её удаление или запрос ответа.
	 * @return Objects\Message
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#sendanimation
	 */
	public function sendAnimation(
		int|string                                                                                                   $chatId,
		string                                                                                                       $animation,
		string|null                                                                                                  $businessConnectionId = null,
		int|null                                                                                                     $messageThreadId = null,
		int|null                                                                                                     $directMessagesTopicId = null,
		Objects\EphemeralMessageParameters|null                                                                      $ephemeralMessageParameters = null,
		int|null                                                                                                     $duration = null,
		int|null                                                                                                     $width = null,
		int|null                                                                                                     $height = null,
		string|null                                                                                                  $thumbnail = null,
		string|null                                                                                                  $caption = null,
		Enums\ParseModeEnum|null                                                                                     $parseMode = null,
		array|null                                                                                                   $captionEntities = null,
		bool|null                                                                                                    $showCaptionAboveMedia = null,
		bool|null                                                                                                    $hasSpoiler = null,
		bool|null                                                                                                    $disableNotification = null,
		bool|null                                                                                                    $protectContent = null,
		bool|null                                                                                                    $allowPaidBroadcast = null,
		string|null                                                                                                  $messageEffectId = null,
		Objects\SuggestedPostParameters|null                                                                         $suggestedPostParameters = null,
		Objects\ReplyParameters|null                                                                                 $replyParameters = null,
		Objects\InlineKeyboardMarkup|Objects\ReplyKeyboardMarkup|Objects\ReplyKeyboardRemove|Objects\ForceReply|null $replyMarkup = null,
	): Objects\Message
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"animation" => $animation,
				"business_connection_id" => $businessConnectionId,
				"message_thread_id" => $messageThreadId,
				"direct_messages_topic_id" => $directMessagesTopicId,
				"ephemeral_message_parameters" => $ephemeralMessageParameters?->getAsArray(),
				"duration" => $duration,
				"width" => $width,
				"height" => $height,
				"thumbnail" => $thumbnail,
				"caption" => $caption,
				"parse_mode" => $parseMode?->value,
				"caption_entities" => $captionEntities,
				"show_caption_above_media" => $showCaptionAboveMedia,
				"has_spoiler" => $hasSpoiler,
				"disable_notification" => $disableNotification,
				"protect_content" => $protectContent,
				"allow_paid_broadcast" => $allowPaidBroadcast,
				"message_effect_id" => $messageEffectId,
				"suggested_post_parameters" => $suggestedPostParameters?->getAsArray(),
				"reply_parameters" => $replyParameters?->getAsArray(),
				"reply_markup" => $replyMarkup?->getAsArray(),
			],
			headers: ["Content-Type" => "multipart/form-data"],
		);

		return new Objects\Message($response->getData());
	}

}
