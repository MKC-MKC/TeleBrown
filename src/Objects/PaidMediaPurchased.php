<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class PaidMediaPurchased extends ResponseWrapper
{

	/**
	 * Пользователь, купивший медиа.
	 *
	 * @return User
	 * @see https://core.telegram.org/bots/api#paidmediapurchased
	 */
	public function getFrom(): User
	{
		$data = $this->getData("from");
		return new User($data);
	}

	/**
	 * Указанные ботом данные платного медиа.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#paidmediapurchased
	 */
	public function getPaidMediaPayload(): string
	{
		return (string)$this->getData("paid_media_payload");
	}

}
