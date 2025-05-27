<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use RuntimeException;
use Haikiri\TeleBrown\ResponseWrapper;
use Haikiri\TeleBrown\Enums\MessageOriginEnum;

/**
 * MessageOrigin – This object describes the origin of a message.
 * @see https://core.telegram.org/bots/api#messageorigin
 */
class MessageOrigin extends ResponseWrapper
{

	public static function getOrigin(array $response): self
	{
		$source = $response["type"];
		return match ($source) {
			MessageOriginEnum::USER->value => new MessageOrigin\MessageOriginUser($response),
			MessageOriginEnum::HIDDEN_USER->value => new MessageOrigin\MessageOriginHiddenUser($response),
			MessageOriginEnum::CHAT->value => new MessageOrigin\MessageOriginChat($response),
			MessageOriginEnum::CHANNEL->value => new MessageOrigin\MessageOriginChannel($response),
			default => throw new RuntimeException("Unknown origin message type: `$source`"),
		};
	}

}
