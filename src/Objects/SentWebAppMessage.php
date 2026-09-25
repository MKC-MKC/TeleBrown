<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class SentWebAppMessage extends ResponseWrapper
{

	/**
	 * Необязательно. Идентификатор отправленного inline-сообщения. Доступен только при наличии inline-клавиатуры.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#sentwebappmessage
	 */
	public function getInlineMessageId(): string|null
	{
		return $this->getData("inline_message_id");
	}

}
