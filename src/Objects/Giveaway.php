<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class Giveaway extends ResponseWrapper
{

	/**
	 * Чаты, в которые пользователь должен вступить для участия.
	 *
	 * @return Chat[]
	 * @see https://core.telegram.org/bots/api#giveaway
	 */
	public function getChats(): array
	{
		return array_map(static fn(array $item): Chat => new Chat($item), (array)$this->getData("chats", []));
	}

	/**
	 * Время выбора победителей в Unix-формате.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#giveaway
	 */
	public function getWinnersSelectionDate(): int
	{
		return (int)$this->getData("winners_selection_date");
	}

	/**
	 * Число пользователей, которые должны стать победителями.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#giveaway
	 */
	public function getWinnerCount(): int
	{
		return (int)$this->getData("winner_count");
	}

	/**
	 * Необязательно. True, если участвовать могут только вступившие после начала розыгрыша.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#giveaway
	 */
	public function isOnlyNewMembers(): bool
	{
		return (bool)$this->getData("only_new_members");
	}

	/**
	 * Необязательно. True, если список победителей будет виден всем.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#giveaway
	 */
	public function hasPublicWinners(): bool
	{
		return (bool)$this->getData("has_public_winners");
	}

	/**
	 * Необязательно. Описание дополнительного приза.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#giveaway
	 */
	public function getPrizeDescription(): string|null
	{
		return $this->getData("prize_description");
	}

	/**
	 * Необязательно. Двухбуквенные коды стран участников ISO 3166-1 alpha-2; пустой список разрешает все страны.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#giveaway
	 */
	public function getCountryCodes(): array
	{
		return (array)$this->getData("country_codes", []);
	}

	/**
	 * Необязательно. Количество Telegram Stars, распределяемых между победителями.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#giveaway
	 */
	public function getPrizeStarCount(): int|null
	{
		return $this->getData("prize_star_count");
	}

	/**
	 * Необязательно. Число месяцев выигранной подписки Telegram Premium.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#giveaway
	 */
	public function getPremiumSubscriptionMonthCount(): int|null
	{
		return $this->getData("premium_subscription_month_count");
	}

}
