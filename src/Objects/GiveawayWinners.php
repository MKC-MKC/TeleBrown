<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class GiveawayWinners extends ResponseWrapper
{

	/**
	 * Чат, создавший розыгрыш.
	 *
	 * @return Chat
	 * @see https://core.telegram.org/bots/api#giveawaywinners
	 */
	public function getChat(): Chat
	{
		$data = $this->getData("chat");
		return new Chat($data);
	}

	/**
	 * Идентификатор сообщения с розыгрышем в чате.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#giveawaywinners
	 */
	public function getGiveawayMessageId(): int
	{
		return (int)$this->getData("giveaway_message_id");
	}

	/**
	 * Время выбора победителей в Unix-формате.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#giveawaywinners
	 */
	public function getWinnersSelectionDate(): int
	{
		return (int)$this->getData("winners_selection_date");
	}

	/**
	 * Общее число победителей.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#giveawaywinners
	 */
	public function getWinnerCount(): int
	{
		return (int)$this->getData("winner_count");
	}

	/**
	 * Список победителей, не более 100 пользователей.
	 *
	 * @return User[]
	 * @see https://core.telegram.org/bots/api#giveawaywinners
	 */
	public function getWinners(): array
	{
		return array_map(static fn(array $item): User => new User($item), (array)$this->getData("winners", []));
	}

	/**
	 * Необязательно. Число других чатов, в которые требовалось вступить.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#giveawaywinners
	 */
	public function getAdditionalChatCount(): int|null
	{
		return $this->getData("additional_chat_count");
	}

	/**
	 * Необязательно. Количество Telegram Stars, распределённых между победителями.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#giveawaywinners
	 */
	public function getPrizeStarCount(): int|null
	{
		return $this->getData("prize_star_count");
	}

	/**
	 * Необязательно. Число месяцев выигранной подписки Telegram Premium.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#giveawaywinners
	 */
	public function getPremiumSubscriptionMonthCount(): int|null
	{
		return $this->getData("premium_subscription_month_count");
	}

	/**
	 * Необязательно. Количество нераспределённых призов.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#giveawaywinners
	 */
	public function getUnclaimedPrizeCount(): int|null
	{
		return $this->getData("unclaimed_prize_count");
	}

	/**
	 * Необязательно. True, если выиграть могли только вступившие после начала розыгрыша.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#giveawaywinners
	 */
	public function isOnlyNewMembers(): bool
	{
		return (bool)$this->getData("only_new_members");
	}

	/**
	 * Необязательно. True, если розыгрыш отменён из-за возврата оплаты.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#giveawaywinners
	 */
	public function isWasRefunded(): bool
	{
		return (bool)$this->getData("was_refunded");
	}

	/**
	 * Необязательно. Описание дополнительного приза.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#giveawaywinners
	 */
	public function getPrizeDescription(): string|null
	{
		return $this->getData("prize_description");
	}

}
