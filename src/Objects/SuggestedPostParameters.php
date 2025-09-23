<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * SuggestedPostParameters – Contains parameters of a post that is being suggested by the bot.
 * @see https://core.telegram.org/bots/api#suggestedpostparameters
 */
class SuggestedPostParameters extends ResponseWrapper
{

	/**
	 * Опционально. Предлагаемая цена за пост. Если поле опущено, то пост является неоплачиваемым.
	 * Optional. Proposed price for the post. If the field is omitted, then the post is unpaid.
	 *
	 * @return SuggestedPostPrice
	 */
	public function getPrice(): SuggestedPostPrice
	{
		return new SuggestedPostPrice($this->getData("price"));
	}

	/**
	 * Опционально. Предлагаемая дата отправки поста. Если указано, то дата должна быть между 300 секундами и 2678400 секундами (30 днями) в будущем.
	 * Если поле опущено, то пост может быть опубликован в любое время в течение 30 дней по усмотрению пользователя, который его одобряет.
	 *
	 * Optional. Proposed send date of the post. If specified, then the date must be between 300 second and 2678400 seconds (30 days) in the future.
	 * If the field is omitted, then the post can be published at any time within 30 days at the sole discretion of the user who approves it.
	 *
	 * @return int
	 */
	public function getSendDate(): int
	{
		return (int)$this->getData("send_date");
	}

}
