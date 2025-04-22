<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * MessageId – This object represents a unique message identifier.
 * @see https://core.telegram.org/bots/api#messageid
 */
class MessageId extends Type
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	/**
	 * Unique message identifier.
	 * In specific instances (e.g., message containing a video sent to a big chat),
	 * the server might automatically schedule a message instead of sending it immediately.
	 * In such cases, this field will be 0 and the relevant message will be unusable until it is actually sent
	 *
	 * @return int
	 */
	public function getId(): int
	{
		return (int)$this->getData("message_id") ?? 0;
	}

}
