<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects;

trait LiveLocations
{

	/**
	 * Используйте этот метод для изменения сообщений с трансляцией геопозиции.
	 * Геопозицию можно изменять до истечения live_period или вызова stopMessageLiveLocation.
	 * При успешном выполнении возвращается изменённое сообщение Message, для inline-сообщения возвращается true.
	 *
	 * @param float $latitude Широта новой геопозиции.
	 * @param float $longitude Долгота новой геопозиции.
	 * @param int|string|null $chatId ID чата или имя бота, супергруппы или канала в формате @username. Обязателен без inlineMessageId.
	 * @param int|null $messageId ID изменяемого сообщения. Обязателен без inlineMessageId.
	 * @param string|null $inlineMessageId ID inline-сообщения. Обязателен без chatId и messageId.
	 * @param string|null $businessConnectionId ID бизнес-подключения, от имени которого отправлено сообщение.
	 * @param int|null $livePeriod Новый срок трансляции в секундах с даты отправки сообщения; 0x7FFFFFFF для бессрочной трансляции.
	 * Новый срок не должен превышать текущий более чем на сутки, а дата окончания должна оставаться в пределах следующих 90 дней.
	 * Если не указан, срок трансляции остаётся прежним.
	 * @param float|null $horizontalAccuracy Радиус погрешности геопозиции в метрах, 0-1500.
	 * @param int|null $heading Направление движения пользователя в градусах, 1-360.
	 * @param int|null $proximityAlertRadius Расстояние для оповещений о приближении другого участника чата в метрах, 1-100000.
	 * @param Objects\InlineKeyboardMarkup|null $replyMarkup Новая inline-клавиатура.
	 * @return Objects\Message|bool
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#editmessagelivelocation
	 */
	public function editMessageLiveLocation(
		float                              $latitude,
		float                              $longitude,
		int|string|null                    $chatId = null,
		int|null                           $messageId = null,
		string|null                        $inlineMessageId = null,
		string|null                        $businessConnectionId = null,
		int|null                           $livePeriod = null,
		float|null                         $horizontalAccuracy = null,
		int|null                           $heading = null,
		int|null                           $proximityAlertRadius = null,
		Objects\InlineKeyboardMarkup|null $replyMarkup = null,
	): Objects\Message|bool
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"latitude" => $latitude,
				"longitude" => $longitude,
				"chat_id" => $chatId,
				"message_id" => $messageId,
				"inline_message_id" => $inlineMessageId,
				"business_connection_id" => $businessConnectionId,
				"live_period" => $livePeriod,
				"horizontal_accuracy" => $horizontalAccuracy,
				"heading" => $heading,
				"proximity_alert_radius" => $proximityAlertRadius,
				"reply_markup" => $replyMarkup?->getAsArray(),
			]
		);

		$result = $response->getData();

		return is_bool($result) ? $result : new Objects\Message($result);
	}

	/**
	 * Используйте этот метод для остановки трансляции геопозиции до истечения live_period.
	 * При успешном выполнении возвращается изменённое сообщение Message, для inline-сообщения возвращается true.
	 *
	 * @param int|string|null $chatId ID чата или имя бота, супергруппы или канала в формате @username. Обязателен без inlineMessageId.
	 * @param int|null $messageId ID сообщения с трансляцией геопозиции. Обязателен без inlineMessageId.
	 * @param string|null $inlineMessageId ID inline-сообщения. Обязателен без chatId и messageId.
	 * @param string|null $businessConnectionId ID бизнес-подключения, от имени которого отправлено сообщение.
	 * @param Objects\InlineKeyboardMarkup|null $replyMarkup Новая inline-клавиатура.
	 * @return Objects\Message|bool
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#stopmessagelivelocation
	 */
	public function stopMessageLiveLocation(
		int|string|null                    $chatId = null,
		int|null                           $messageId = null,
		string|null                        $inlineMessageId = null,
		string|null                        $businessConnectionId = null,
		Objects\InlineKeyboardMarkup|null $replyMarkup = null,
	): Objects\Message|bool
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"message_id" => $messageId,
				"inline_message_id" => $inlineMessageId,
				"business_connection_id" => $businessConnectionId,
				"reply_markup" => $replyMarkup?->getAsArray(),
			]
		);

		$result = $response->getData();

		return is_bool($result) ? $result : new Objects\Message($result);
	}

}
