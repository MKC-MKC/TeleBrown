<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Enums;
use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects;

trait MediaGroups
{

	/**
	 * Отправляет альбом фотографий, живых фотографий, видео, документов или аудио.
	 * Документы и аудиофайлы можно объединять только с сообщениями того же типа.
	 * Возвращается массив отправленных сообщений Message.
	 *
	 * @param int|string $chatId Идентификатор целевого чата или его @username.
	 * @param array $media От 2 до 10 объектов InputMedia для альбома; в файловых полях можно указать локальные пути.
	 * @param string|null $businessConnectionId Идентификатор бизнес-подключения, от имени которого отправляется сообщение.
	 * @param int|null $messageThreadId Идентификатор темы форума; для супергрупп и личных чатов ботов с включённым режимом тем.
	 * @param int|null $directMessagesTopicId Идентификатор темы личных сообщений канала; обязателен для чатов личных сообщений каналов.
	 * @param bool|null $disableNotification Отправка без звука уведомления.
	 * @param bool|null $protectContent Защищает содержимое от пересылки и сохранения.
	 * @param bool|null $allowPaidBroadcast Разрешает до 1000 сообщений в секунду за 0,1 звезды Telegram за сообщение.
	 * @param string|null $messageEffectId Идентификатор эффекта сообщения; только для личных чатов.
	 * @param Objects\ReplyParameters|null $replyParameters Описание сообщения, на которое отправляется ответ.
	 * @return Objects\Message[]
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#sendmediagroup
	 */
	public function sendMediaGroup(
		int|string                   $chatId,
		array                        $media,
		string|null                  $businessConnectionId = null,
		int|null                     $messageThreadId = null,
		int|null                     $directMessagesTopicId = null,
		bool|null                    $disableNotification = null,
		bool|null                    $protectContent = null,
		bool|null                    $allowPaidBroadcast = null,
		string|null                  $messageEffectId = null,
		Objects\ReplyParameters|null $replyParameters = null,
	): array
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"media" => $media,
				"business_connection_id" => $businessConnectionId,
				"message_thread_id" => $messageThreadId,
				"direct_messages_topic_id" => $directMessagesTopicId,
				"disable_notification" => $disableNotification,
				"protect_content" => $protectContent,
				"allow_paid_broadcast" => $allowPaidBroadcast,
				"message_effect_id" => $messageEffectId,
				"reply_parameters" => $replyParameters?->getAsArray(),
			],
			headers: ["Content-Type" => "multipart/form-data"],
		);

		return array_map(static fn(array $item): Objects\Message => new Objects\Message($item), $response->getData());
	}

	/**
	 * Отправляет платные медиа.
	 * Возвращается отправленное сообщение Message.
	 *
	 * @param int|string $chatId Идентификатор целевого чата или его @username.
	 * @param int $starCount Стоимость доступа от 1 до 25000 звёзд Telegram.
	 * @param Objects\InputPaidMedia[]|array $media До 10 объектов InputPaidMedia; в файловых полях можно указать локальные пути.
	 * @param string|null $businessConnectionId Идентификатор бизнес-подключения, от имени которого отправляется сообщение.
	 * @param int|null $messageThreadId Идентификатор темы форума; для супергрупп и личных чатов ботов с включённым режимом тем.
	 * @param int|null $directMessagesTopicId Идентификатор темы личных сообщений канала; обязателен для чатов личных сообщений каналов.
	 * @param string|null $payload Служебные данные платного медиа, от 0 до 128 байт; пользователю не показываются.
	 * @param string|null $caption Подпись к медиа, от 0 до 1024 символов после разбора сущностей.
	 * @param Enums\ParseModeEnum|null $parseMode Режим разбора сущностей в подписи.
	 * @param Objects\MessageEntity[]|array|null $captionEntities Сущности подписи; можно указать вместо parse_mode.
	 * @param bool|null $showCaptionAboveMedia Передайте True, чтобы показать подпись над медиа.
	 * @param bool|null $disableNotification Отправка без звука уведомления.
	 * @param bool|null $protectContent Защищает содержимое от пересылки и сохранения.
	 * @param bool|null $allowPaidBroadcast Разрешает до 1000 сообщений в секунду за 0,1 звезды Telegram за сообщение.
	 * @param Objects\SuggestedPostParameters|null $suggestedPostParameters Параметры предлагаемой публикации; только для чатов личных сообщений каналов.
	 * @param Objects\ReplyParameters|null $replyParameters Описание сообщения, на которое отправляется ответ.
	 * @param Objects\InlineKeyboardMarkup|Objects\ReplyKeyboardMarkup|Objects\ReplyKeyboardRemove|Objects\ForceReply|null $replyMarkup Inline-клавиатура, клавиатура ответа, её удаление или запрос ответа.
	 * @return Objects\Message
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#sendpaidmedia
	 */
	public function sendPaidMedia(
		int|string                                                                                                   $chatId,
		int                                                                                                          $starCount,
		array                                                                                                        $media,
		string|null                                                                                                  $businessConnectionId = null,
		int|null                                                                                                     $messageThreadId = null,
		int|null                                                                                                     $directMessagesTopicId = null,
		string|null                                                                                                  $payload = null,
		string|null                                                                                                  $caption = null,
		Enums\ParseModeEnum|null                                                                                     $parseMode = null,
		array|null                                                                                                   $captionEntities = null,
		bool|null                                                                                                    $showCaptionAboveMedia = null,
		bool|null                                                                                                    $disableNotification = null,
		bool|null                                                                                                    $protectContent = null,
		bool|null                                                                                                    $allowPaidBroadcast = null,
		Objects\SuggestedPostParameters|null                                                                         $suggestedPostParameters = null,
		Objects\ReplyParameters|null                                                                                 $replyParameters = null,
		Objects\InlineKeyboardMarkup|Objects\ReplyKeyboardMarkup|Objects\ReplyKeyboardRemove|Objects\ForceReply|null $replyMarkup = null,
	): Objects\Message
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"star_count" => $starCount,
				"media" => $media,
				"business_connection_id" => $businessConnectionId,
				"message_thread_id" => $messageThreadId,
				"direct_messages_topic_id" => $directMessagesTopicId,
				"payload" => $payload,
				"caption" => $caption,
				"parse_mode" => $parseMode?->value,
				"caption_entities" => $captionEntities,
				"show_caption_above_media" => $showCaptionAboveMedia,
				"disable_notification" => $disableNotification,
				"protect_content" => $protectContent,
				"allow_paid_broadcast" => $allowPaidBroadcast,
				"suggested_post_parameters" => $suggestedPostParameters?->getAsArray(),
				"reply_parameters" => $replyParameters?->getAsArray(),
				"reply_markup" => $replyMarkup?->getAsArray(),
			],
			headers: ["Content-Type" => "multipart/form-data"],
		);

		return new Objects\Message($response->getData());
	}

}
