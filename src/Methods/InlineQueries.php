<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Enums;
use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects;

trait InlineQueries
{

	/**
	 * Используйте этот метод, чтобы ответить на inline-запрос.
	 * При успешном выполнении возвращается True. Допускается не более 50 результатов на запрос.
	 *
	 * @param string $inlineQueryId Уникальный идентификатор запроса, на который отправляется ответ.
	 * @param array[] $results Массив результатов InlineQueryResult, например [["type" => "article", "id" => "1", "title" => "Ответ", "input_message_content" => ["message_text" => "Текст"]]].
	 * @param int|null $cacheTime Максимальное время кеширования результатов на сервере в секундах. По умолчанию 300.
	 * @param bool|null $isPersonal Передайте True, чтобы кешировать результаты только для пользователя, отправившего запрос.
	 * @param string|null $nextOffset Смещение для следующего запроса, не более 64 байт. Передайте пустую строку, если результатов больше нет.
	 * @param Objects\InlineQueryResultsButton|null $button Кнопка, которая будет показана над результатами inline-запроса.
	 * @return bool
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#answerinlinequery
	 * @see https://core.telegram.org/bots/api#inlinequeryresult
	 * @see https://core.telegram.org/bots/api#inputmessagecontent
	 */
	public function answerInlineQuery(
		string                               $inlineQueryId,
		array                                $results,
		int|null                             $cacheTime = null,
		bool|null                            $isPersonal = null,
		string|null                          $nextOffset = null,
		Objects\InlineQueryResultsButton|null $button = null,
	): bool
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"inline_query_id" => $inlineQueryId,
				"results" => $results,
				"cache_time" => $cacheTime,
				"is_personal" => $isPersonal,
				"next_offset" => $nextOffset,
				"button" => $button?->getAsArray(),
			]
		);

		return $response->isSuccess();
	}

	/**
	 * Используйте этот метод, чтобы отправить ответ на запрос от inline-клавиатуры.
	 * При успешном выполнении возвращается True.
	 *
	 * @param string $callbackQueryId Уникальный идентификатор запроса, на который отправляется ответ.
	 * @param string|null $text Текст уведомления, от 0 до 200 символов.
	 * @param bool|null $showAlert Передайте True, чтобы показать предупреждение вместо уведомления.
	 * @param string|null $url URL, который будет открыт клиентом пользователя.
	 * @param int|null $cacheTime Максимальное время кеширования ответа в секундах. По умолчанию 0.
	 * @return bool
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#answercallbackquery
	 */
	public function answerCallbackQuery(
		string      $callbackQueryId,
		string|null $text = null,
		bool|null   $showAlert = null,
		string|null $url = null,
		int|null    $cacheTime = null,
	): bool
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"callback_query_id" => $callbackQueryId,
				"text" => $text,
				"show_alert" => $showAlert,
				"url" => $url,
				"cache_time" => $cacheTime,
			],
		);

		return $response->isSuccess();
	}

	/**
	 * Сохраняет кнопку, которую можно использовать в методе requestChat Mini App.
	 * Возвращается объект PreparedKeyboardButton.
	 *
	 * @param int $userId Уникальный идентификатор пользователя.
	 * @param Objects\KeyboardButton $button Кнопка с запросом пользователя, чата или управляемого бота.
	 * @return Objects\PreparedKeyboardButton
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#savepreparedkeyboardbutton
	 */
	public function savePreparedKeyboardButton(
		int                    $userId,
		Objects\KeyboardButton $button,
	): Objects\PreparedKeyboardButton
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"user_id" => $userId,
				"button" => $button->getAsArray(),
			],
		);

		return new Objects\PreparedKeyboardButton($response->getData());
	}

}
