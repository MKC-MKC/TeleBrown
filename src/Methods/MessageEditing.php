<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Enums;
use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects;

trait MessageEditing
{

	/**
	 * Используйте этот метод, чтобы изменить только клавиатуру сообщения.
	 * При успешном выполнении возвращается отредактированное сообщение Message,
	 * а для inline-сообщения возвращается True.
	 * Бизнес-сообщения, отправленные не ботом и не содержащие inline-клавиатуру,
	 * можно редактировать только в течение 48 часов с момента отправки.
	 *
	 * @param int|string|null $chatId Идентификатор чата или @username; обязателен, если inlineMessageId не указан.
	 * @param int|null $messageId Идентификатор сообщения; обязателен, если inlineMessageId не указан.
	 * @param Objects\InlineKeyboardMarkup|null $replyMarkup Объект новой inline-клавиатуры.
	 * @param string|null $inlineMessageId Идентификатор inline-сообщения; обязателен, если chatId и messageId не указаны.
	 * @param string|null $businessConnectionId Идентификатор бизнес-подключения, от имени которого отправлено сообщение.
	 * @return Objects\Message|bool Отредактированное сообщение или True для inline-сообщения.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#editmessagereplymarkup
	 */
	public function editMessageReplyMarkup(
		int|string|null                    $chatId = null,
		?int                               $messageId = null,
		?Objects\InlineKeyboardMarkup      $replyMarkup = null,
		?string                            $inlineMessageId = null,
		?string                            $businessConnectionId = null,
	): Objects\Message|bool
	{
		$result = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"message_id" => $messageId,
				"reply_markup" => $replyMarkup?->getAsArray(),
				"inline_message_id" => $inlineMessageId,
				"business_connection_id" => $businessConnectionId,
			],
		)->getData();

		return is_bool($result) ? $result : new Objects\Message($result);
	}


	/**
	 * Используйте этот метод, чтобы изменить подпись сообщения.
	 * При успешном выполнении возвращается отредактированное сообщение Message,
	 * а для inline-сообщения возвращается True.
	 * Бизнес-сообщения, отправленные не ботом и не содержащие inline-клавиатуру,
	 * можно редактировать только в течение 48 часов с момента отправки.
	 *
	 * @param int|string|null $chatId Идентификатор чата или @username; обязателен, если inlineMessageId не указан.
	 * @param int|null $messageId Идентификатор сообщения; обязателен, если inlineMessageId не указан.
	 * @param string|null $caption Новая подпись, от 0 до 1024 символов после разбора сущностей.
	 * @param string|null $inlineMessageId Идентификатор inline-сообщения; обязателен, если chatId и messageId не указаны.
	 * @param string|null $businessConnectionId Идентификатор бизнес-подключения, от имени которого отправлено сообщение.
	 * @param Enums\ParseModeEnum|null $parseMode Режим разбора сущностей в подписи.
	 * @param Objects\MessageEntity[]|array|null $captionEntities Список сущностей подписи; можно указать вместо parseMode.
	 * @param bool|null $showCaptionAboveMedia True, если подпись должна отображаться над анимацией, фотографией или видео.
	 * @param Objects\InlineKeyboardMarkup|null $replyMarkup Объект inline-клавиатуры.
	 * @return Objects\Message|bool Отредактированное сообщение или True для inline-сообщения.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#editmessagecaption
	 */
	public function editMessageCaption(
		int|string|null               $chatId = null,
		?int                          $messageId = null,
		?string                       $caption = null,
		?string                       $inlineMessageId = null,
		?string                       $businessConnectionId = null,
		?Enums\ParseModeEnum          $parseMode = null,
		?array                        $captionEntities = null,
		?bool                         $showCaptionAboveMedia = null,
		?Objects\InlineKeyboardMarkup $replyMarkup = null,
	): Objects\Message|bool
	{
		$result = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"message_id" => $messageId,
				"caption" => $caption,
				"inline_message_id" => $inlineMessageId,
				"business_connection_id" => $businessConnectionId,
				"parse_mode" => $parseMode?->value,
				"caption_entities" => $captionEntities,
				"show_caption_above_media" => $showCaptionAboveMedia,
				"reply_markup" => $replyMarkup?->getAsArray(),
			],
		)->getData();

		return is_bool($result) ? $result : new Objects\Message($result);
	}

}
