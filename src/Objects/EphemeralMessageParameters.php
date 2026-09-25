<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class EphemeralMessageParameters extends ResponseWrapper
{

	/**
	 * Получаем идентификатор пользователя, которому предназначено сообщение.
	 *
	 * @return int Идентификатор получателя, например 123456789.
	 * @see https://core.telegram.org/bots/api#ephemeralmessageparameters
	 */
	public function getReceiverUserId(): int
	{
		return (int)$this->getData("receiver_user_id");
	}

	/**
	 * Получаем идентификатор callback-запроса, вызвавшего отправку сообщения.
	 *
	 * @return string|null Идентификатор запроса или null, если он не указан.
	 * @see https://core.telegram.org/bots/api#ephemeralmessageparameters
	 */
	public function getCallbackQueryId(): ?string
	{
		return $this->getData("callback_query_id");
	}

	/**
	 * Проверяем, нужно ли показать сообщение вместо исходного сообщения callback-запроса.
	 * Для callback-запросов из ephemeral-сообщений этот параметр должен быть false.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#ephemeralmessageparameters
	 */
	public function isReplaceCallbackQueryMessage(): bool
	{
		return (bool)$this->getData("replace_callback_query_message", false);
	}

}
