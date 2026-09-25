<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class SentGuestMessage extends ResponseWrapper
{

	/**
	 * Идентификатор отправленного inline-сообщения.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#sentguestmessage
	 */
	public function getInlineMessageId(): string
	{
		return (string)$this->getData("inline_message_id");
	}

}
