<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * AcceptedGiftTypes – This object describes the types of gifts that can be gifted to a user or a chat.
 * @see https://core.telegram.org/bots/api#accepteddgifttypes
 */
class AcceptedGiftTypes extends ResponseWrapper
{

	public function isUnlimitedGifts(): bool
	{
		return (bool)$this->getData("unlimited_gifts");
	}

	public function isLimitedGifts(): bool
	{
		return (bool)$this->getData("limited_gifts");
	}

	public function isUniqueGifts(): bool
	{
		return (bool)$this->getData("unique_gifts");
	}

	public function isPremiumSubscription(): bool
	{
		return (bool)$this->getData("premium_subscription");
	}

}
