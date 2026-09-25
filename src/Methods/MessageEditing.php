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


	/**
	 * Используйте этот метод, чтобы изменить анимацию, аудио, документ, live photo, фотографию
	 * или видео, либо заменить текстовое или rich-сообщение на медиа.
	 * В аудиоальбоме сообщение можно заменить только на аудио, в альбоме документов только на документ,
	 * а в остальных альбомах на фотографию, live photo или видео.
	 * При редактировании inline-сообщения нельзя загрузить новый файл; используйте file_id или URL.
	 * При успешном выполнении возвращается отредактированное сообщение Message,
	 * а для inline-сообщения возвращается True.
	 * Бизнес-сообщения, отправленные не ботом и не содержащие inline-клавиатуру,
	 * можно редактировать только в течение 48 часов с момента отправки.
	 *
	 * @param Objects\InputMedia|array $media Новое медиа, например ["type" => "photo", "media" => "file_id"].
	 * @param int|string|null $chatId Идентификатор чата или @username; обязателен, если inlineMessageId не указан.
	 * @param int|null $messageId Идентификатор сообщения; обязателен, если inlineMessageId не указан.
	 * @param string|null $inlineMessageId Идентификатор inline-сообщения; обязателен, если chatId и messageId не указаны.
	 * @param string|null $businessConnectionId Идентификатор бизнес-подключения, от имени которого отправлено сообщение.
	 * @param Objects\InlineKeyboardMarkup|null $replyMarkup Объект новой inline-клавиатуры.
	 * @return Objects\Message|bool Отредактированное сообщение или True для inline-сообщения.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#editmessagemedia
	 */
	public function editMessageMedia(
		Objects\InputMedia|array      $media,
		int|string|null               $chatId = null,
		?int                          $messageId = null,
		?string                       $inlineMessageId = null,
		?string                       $businessConnectionId = null,
		?Objects\InlineKeyboardMarkup $replyMarkup = null,
	): Objects\Message|bool
	{
		$result = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"media" => $media,
				"chat_id" => $chatId,
				"message_id" => $messageId,
				"inline_message_id" => $inlineMessageId,
				"business_connection_id" => $businessConnectionId,
				"reply_markup" => $replyMarkup?->getAsArray(),
			],
			headers: ["Content-Type" => $inlineMessageId === null ? "multipart/form-data" : "application/json"],
		)->getData();

		return is_bool($result) ? $result : new Objects\Message($result);
	}

	/**
	 * Изменяем список задач от имени подключённого бизнес-аккаунта.
	 *
	 * @param string $businessConnectionId Идентификатор бизнес-подключения, от имени которого изменяется сообщение.
	 * @param int|string $chatId Идентификатор целевого чата или @username бота.
	 * @param int $messageId Идентификатор целевого сообщения.
	 * @param Objects\InputChecklist $checklist Новый список задач.
	 * @param Objects\InlineKeyboardMarkup|null $replyMarkup Новая inline-клавиатура сообщения.
	 * @return Objects\Message Изменённое сообщение.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#editmessagechecklist
	 */
	public function editMessageChecklist(
		string                            $businessConnectionId,
		int|string                        $chatId,
		int                               $messageId,
		Objects\InputChecklist            $checklist,
		Objects\InlineKeyboardMarkup|null $replyMarkup = null,
	): Objects\Message
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"business_connection_id" => $businessConnectionId,
				"chat_id" => $chatId,
				"message_id" => $messageId,
				"checklist" => $checklist->getAsArray(),
				"reply_markup" => $replyMarkup?->getAsArray(),
			],
		);

		return new Objects\Message($response->getData());
	}

}
