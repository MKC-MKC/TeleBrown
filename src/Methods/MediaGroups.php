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

}
