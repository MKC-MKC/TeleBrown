<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects;

trait RichMessages
{

	/**
	 * Отправляет расширенное сообщение. Если блок содержит медиа, бот должен иметь право
	 * отправлять этот тип медиа в чат. Возвращается отправленное сообщение Message.
	 *
	 * @param int|string $chatId Идентификатор целевого чата или его @username.
	 * @param Objects\InputRichMessage $richMessage Содержимое сообщения. Например new InputRichMessage(["html" => "<p>Текст</p>"]).
	 * @param string|null $businessConnectionId Идентификатор бизнес-подключения. Отправка доступна, только если пользователь бизнес-аккаунта может отправлять расширенные сообщения.
	 * @param int|null $messageThreadId Идентификатор темы форума; для супергрупп и личных чатов ботов с включённым режимом тем.
	 * @param int|null $directMessagesTopicId Идентификатор темы личных сообщений канала; обязателен для чатов личных сообщений каналов.
	 * @param Objects\EphemeralMessageParameters|null $ephemeralMessageParameters Параметры сообщения, видимого только выбранному пользователю и боту.
	 * @param bool|null $disableNotification Отправка без звука уведомления.
	 * @param bool|null $protectContent Защищает содержимое от пересылки и сохранения.
	 * @param bool|null $allowPaidBroadcast Разрешает до 1000 сообщений в секунду за 0,1 звезды Telegram за сообщение.
	 * @param string|null $messageEffectId Идентификатор эффекта сообщения; только для личных чатов.
	 * @param Objects\SuggestedPostParameters|null $suggestedPostParameters Параметры предлагаемой публикации; только для чатов личных сообщений каналов.
	 * @param Objects\ReplyParameters|null $replyParameters Описание сообщения, на которое отправляется ответ.
	 * @param Objects\InlineKeyboardMarkup|Objects\ReplyKeyboardMarkup|Objects\ReplyKeyboardRemove|Objects\ForceReply|null $replyMarkup Inline-клавиатура, клавиатура ответа, её удаление или запрос ответа.
	 * @return Objects\Message
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#sendrichmessage
	 */
	public function sendRichMessage(
		int|string                                                                                                   $chatId,
		Objects\InputRichMessage                                                                                     $richMessage,
		string|null                                                                                                  $businessConnectionId = null,
		int|null                                                                                                     $messageThreadId = null,
		int|null                                                                                                     $directMessagesTopicId = null,
		Objects\EphemeralMessageParameters|null                                                                      $ephemeralMessageParameters = null,
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
				"rich_message" => $richMessage->getAsArray(),
				"business_connection_id" => $businessConnectionId,
				"message_thread_id" => $messageThreadId,
				"direct_messages_topic_id" => $directMessagesTopicId,
				"ephemeral_message_parameters" => $ephemeralMessageParameters?->getAsArray(),
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
	 * Передаёт пользователю частичное расширенное сообщение во время его генерации.
	 * Черновик служит временным предпросмотром на 30 секунд. После завершения генерации
	 * необходимо вызвать sendRichMessage, чтобы сохранить полное сообщение в чате.
	 * При успешном выполнении возвращается True.
	 *
	 * @param int $chatId Идентификатор личного чата.
	 * @param int $draftId Ненулевой идентификатор черновика. Изменения с тем же идентификатором анимируются.
	 * @param Objects\InputRichMessage $richMessage Частичное содержимое сообщения. Загрузка новых файлов и явная загрузка по URL не поддерживаются.
	 * @param int|null $messageThreadId Идентификатор темы.
	 * @param bool|null $canStop Показывает кнопку остановки генерации. При нажатии бот получит обновление stopped_message_generation.
	 * @param bool|null $keepOnStop Сохраняет черновик после остановки на короткое время или до отправки сообщения ботом. Для постоянного сохранения отправьте новое сообщение.
	 * @return bool
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#sendrichmessagedraft
	 */
	public function sendRichMessageDraft(
		int                      $chatId,
		int                      $draftId,
		Objects\InputRichMessage $richMessage,
		int|null                 $messageThreadId = null,
		bool|null                $canStop = null,
		bool|null                $keepOnStop = null,
	): bool
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"draft_id" => $draftId,
				"rich_message" => $richMessage->getAsArray(),
				"message_thread_id" => $messageThreadId,
				"can_stop" => $canStop,
				"keep_on_stop" => $keepOnStop,
			],
		);

		return $response->isSuccess();
	}

}
