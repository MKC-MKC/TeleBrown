<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

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

}
