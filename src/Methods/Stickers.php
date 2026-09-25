<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects;

trait Stickers
{

	/**
	 * Отправляем статические стикеры WEBP, анимированные TGS или видеостикеры WEBM.
	 * Возвращаем отправленное сообщение.
	 *
	 * @param int|string $chatId Идентификатор целевого чата или @username бота, супергруппы или канала.
	 * @param string $sticker file_id, HTTP URL для WEBP или локальный путь к WEBP, TGS, WEBM. Анимированные и видеостикеры нельзя отправить по URL.
	 * @param string|null $businessConnectionId Идентификатор бизнес-подключения, от имени которого отправляется сообщение.
	 * @param int|null $messageThreadId Идентификатор темы форума; для супергрупп и личных чатов ботов с включённым режимом тем.
	 * @param int|null $directMessagesTopicId Идентификатор темы личных сообщений канала; обязателен при отправке в чат личных сообщений канала.
	 * @param Objects\EphemeralMessageParameters|null $ephemeralMessageParameters Параметры сообщения, видимого только выбранному пользователю и боту.
	 * @param string|null $emoji Эмодзи стикера; только для вновь загружаемых стикеров.
	 * @param bool|null $disableNotification Отправляем сообщение без звука уведомления.
	 * @param bool|null $protectContent Защищаем содержимое от пересылки и сохранения.
	 * @param bool|null $allowPaidBroadcast Разрешаем до 1000 сообщений в секунду за 0,1 звезды Telegram за сообщение.
	 * @param string|null $messageEffectId Идентификатор эффекта сообщения; только для личных чатов.
	 * @param Objects\SuggestedPostParameters|null $suggestedPostParameters Параметры предлагаемой публикации; только для чатов личных сообщений каналов. Ответ на другую предлагаемую публикацию автоматически отклоняет её.
	 * @param Objects\ReplyParameters|null $replyParameters Описание сообщения, на которое отправляется ответ.
	 * @param Objects\InlineKeyboardMarkup|Objects\ReplyKeyboardMarkup|Objects\ReplyKeyboardRemove|Objects\ForceReply|null $replyMarkup Inline-клавиатура, клавиатура ответа, её удаление или запрос ответа.
	 * @return Objects\Message
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#sendsticker
	 */
	public function sendSticker(
		int|string                                                                                                   $chatId,
		string                                                                                                       $sticker,
		string|null                                                                                                  $businessConnectionId = null,
		int|null                                                                                                     $messageThreadId = null,
		int|null                                                                                                     $directMessagesTopicId = null,
		Objects\EphemeralMessageParameters|null                                                                      $ephemeralMessageParameters = null,
		string|null                                                                                                  $emoji = null,
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
				"sticker" => $sticker,
				"business_connection_id" => $businessConnectionId,
				"message_thread_id" => $messageThreadId,
				"direct_messages_topic_id" => $directMessagesTopicId,
				"ephemeral_message_parameters" => $ephemeralMessageParameters?->getAsArray(),
				"emoji" => $emoji,
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
	 * Получаем информацию о стикерах пользовательских эмодзи по их идентификаторам.
	 *
	 * @param string[] $customEmojiIds До 200 идентификаторов пользовательских эмодзи.
	 * @return Objects\Sticker[]
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#getcustomemojistickers
	 */
	public function getCustomEmojiStickers(
		array $customEmojiIds,
	): array
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"custom_emoji_ids" => $customEmojiIds,
			],
		);

		return array_map(static fn(array $item): Objects\Sticker => new Objects\Sticker($item), $response->getData());
	}

	/**
	 * Загружаем файл стикера для дальнейшего использования в createNewStickerSet, addStickerToSet или replaceStickerInSet.
	 * Загруженный файл можно использовать несколько раз.
	 *
	 * @param int $userId Идентификатор владельца файла стикера.
	 * @param string $sticker Путь к локальному файлу стикера WEBP, PNG, TGS или WEBM.
	 * @param string $stickerFormat Формат стикера: static, animated или video.
	 * @return Objects\File
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#uploadstickerfile
	 */
	public function uploadStickerFile(
		int    $userId,
		string $sticker,
		string $stickerFormat,
	): Objects\File
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"user_id" => $userId,
				"sticker" => $sticker,
				"sticker_format" => $stickerFormat,
			],
			headers: ["Content-Type" => "multipart/form-data"],
		);

		return new Objects\File($response->getData());
	}

}
