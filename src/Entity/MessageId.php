<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * MessageId – This object represents a unique message identifier.
 * @see https://core.telegram.org/bots/api#messageid
 */
class MessageId
{
	private array $response;

	public function __construct(array $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array
	{
		return $this->response ?? [];
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
		return (int)$this->getAsArray()["message_id"] ?? 0;
	}

}
