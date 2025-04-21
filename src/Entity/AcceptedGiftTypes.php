<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * AcceptedGiftTypes – This object describes the types of gifts that can be gifted to a user or a chat.
 * @see https://core.telegram.org/bots/api#accepteddgifttypes
 */
class AcceptedGiftTypes
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

	public function isUnlimitedGifts(): bool
	{
		return ($this->getAsArray()["unlimited_gifts"] ?? false);
	}

	public function isLimitedGifts(): bool
	{
		return ($this->getAsArray()["limited_gifts"] ?? false);
	}

	public function isUniqueGifts(): bool
	{
		return ($this->getAsArray()["unique_gifts"] ?? false);
	}

	public function isPremiumSubscription(): bool
	{
		return ($this->getAsArray()["premium_subscription"] ?? false);
	}

}
