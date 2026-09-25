<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Enums;
use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects;

trait EphemeralMessages
{

	/**
	 * Удаляем эфемерное сообщение.
	 * Доставка события удаления пользователю не гарантируется, особенно если он не в сети.
	 *
	 * @param int|string $chatId Идентификатор целевого чата или @username супергруппы.
	 * @param int $receiverUserId Идентификатор пользователя, получившего сообщение.
	 * @param int $ephemeralMessageId Идентификатор эфемерного сообщения.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#deleteephemeralmessage
	 */
	public function deleteEphemeralMessage(
		int|string $chatId,
		int        $receiverUserId,
		int        $ephemeralMessageId,
	): bool
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"receiver_user_id" => $receiverUserId,
				"ephemeral_message_id" => $ephemeralMessageId,
			],
		);

		return $response->isSuccess();
	}

	/**
	 * Изменяем текстовое или rich-сообщение в эфемерном режиме.
	 * Доставка события изменения пользователю не гарантируется, особенно если он не в сети.
	 *
	 * @param int|string $chatId Идентификатор целевого чата или @username супергруппы.
	 * @param int $receiverUserId Идентификатор пользователя, получившего сообщение.
	 * @param int $ephemeralMessageId Идентификатор эфемерного сообщения.
	 * @param string|null $text Новый текст, от 1 до 4096 символов после разбора сущностей. Обязателен, если rich_message не указан.
	 * @param Enums\ParseModeEnum|null         $parseMode Режим разбора сущностей текста или подписи.
	 * @param Objects\MessageEntity[]|array|null $entities Сущности текста, которые можно указать вместо parse_mode.
	 * @param Objects\InputRichMessage|null $richMessage Новое rich-содержимое сообщения. Обязательно, если text не указан.
	 * @param Objects\LinkPreviewOptions|null $linkPreviewOptions Параметры предпросмотра ссылок в сообщении.
	 * @param Objects\InlineKeyboardMarkup|null $replyMarkup Новая inline-клавиатура сообщения.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#editephemeralmessagetext
	 */
	public function editEphemeralMessageText(
		int|string                        $chatId,
		int                               $receiverUserId,
		int                               $ephemeralMessageId,
		string|null                       $text = null,
		Enums\ParseModeEnum|null         $parseMode = null,
		array|null                        $entities = null,
		Objects\InputRichMessage|null     $richMessage = null,
		Objects\LinkPreviewOptions|null   $linkPreviewOptions = null,
		Objects\InlineKeyboardMarkup|null $replyMarkup = null,
	): bool
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"receiver_user_id" => $receiverUserId,
				"ephemeral_message_id" => $ephemeralMessageId,
				"text" => $text,
				"parse_mode" => $parseMode?->value,
				"entities" => $entities,
				"rich_message" => $richMessage?->getAsArray(),
				"link_preview_options" => $linkPreviewOptions?->getAsArray(),
				"reply_markup" => $replyMarkup?->getAsArray(),
			],
			headers: ["Content-Type" => "multipart/form-data"],
		);

		return $response->isSuccess();
	}

	/**
	 * Изменяем медиа эфемерного сообщения.
	 * Доставка события изменения пользователю не гарантируется, особенно если он не в сети.
	 *
	 * @param int|string $chatId Идентификатор целевого чата или @username супергруппы.
	 * @param int $receiverUserId Идентификатор пользователя, получившего сообщение.
	 * @param int $ephemeralMessageId Идентификатор эфемерного сообщения.
	 * @param Objects\InputMedia|array $media Новое медиа, например ["type" => "photo", "media" => "/tmp/photo.jpg"].
	 * @param Objects\InlineKeyboardMarkup|null $replyMarkup Новая inline-клавиатура сообщения.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#editephemeralmessagemedia
	 */
	public function editEphemeralMessageMedia(
		int|string                        $chatId,
		int                               $receiverUserId,
		int                               $ephemeralMessageId,
		Objects\InputMedia|array          $media,
		Objects\InlineKeyboardMarkup|null $replyMarkup = null,
	): bool
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"receiver_user_id" => $receiverUserId,
				"ephemeral_message_id" => $ephemeralMessageId,
				"media" => $media,
				"reply_markup" => $replyMarkup?->getAsArray(),
			],
			headers: ["Content-Type" => "multipart/form-data"],
		);

		return $response->isSuccess();
	}

}
