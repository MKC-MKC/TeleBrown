<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * AcceptedGiftTypes – This object describes the types of gifts that can be gifted to a user or a chat.
 * @see https://core.telegram.org/bots/api#accepteddgifttypes
 */
class AcceptedGiftTypes extends Type
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	public function isUnlimitedGifts(): bool
	{
		return ($this->getData("unlimited_gifts") ?? false);
	}

	public function isLimitedGifts(): bool
	{
		return ($this->getData("limited_gifts") ?? false);
	}

	public function isUniqueGifts(): bool
	{
		return ($this->getData("unique_gifts") ?? false);
	}

	public function isPremiumSubscription(): bool
	{
		return ($this->getData("premium_subscription") ?? false);
	}

}
