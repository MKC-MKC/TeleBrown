<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class ChatBoostSource extends ResponseWrapper
{

	/**
	 * Метод возвращает источник boost.
	 *
	 * @return string
	 */
	public function getSource(): string
	{
		return (string)$this->getData("source");
	}

	/**
	 * Метод возвращает связанного с boost пользователя при его наличии.
	 *
	 * @return User|null
	 */
	public function getUser(): User|null
	{
		$data = $this->getData("user");

		return is_array($data) ? new User($data) : null;
	}

	/**
	 * Метод возвращает идентификатор сообщения о розыгрыше при его наличии.
	 *
	 * @return int|null
	 */
	public function getGiveawayMessageId(): int|null
	{
		$value = $this->getData("giveaway_message_id");

		return $value === null ? null : (int)$value;
	}

	/**
	 * Метод возвращает число звёзд в розыгрыше при его наличии.
	 *
	 * @return int|null
	 */
	public function getPrizeStarCount(): int|null
	{
		$value = $this->getData("prize_star_count");

		return $value === null ? null : (int)$value;
	}

	/**
	 * Метод сообщает, остался ли приз розыгрыша невостребованным.
	 *
	 * @return bool|null
	 */
	public function isUnclaimed(): bool|null
	{
		$value = $this->getData("is_unclaimed");

		return $value === null ? null : (bool)$value;
	}

}
