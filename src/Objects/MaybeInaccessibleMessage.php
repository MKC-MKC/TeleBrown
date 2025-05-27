<?php

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * MaybeInaccessibleMessage – This object describes a message that can be inaccessible to the bot.
 * @see https://core.telegram.org/bots/api#maybeinaccessiblemessage
 */
abstract class MaybeInaccessibleMessage extends ResponseWrapper
{

	public static function getMessage(array $response): self
	{
		return isset($response["date"]) && $response["date"] !== 0
			? new Message($response)
			: new InaccessibleMessage($response);
	}

}
