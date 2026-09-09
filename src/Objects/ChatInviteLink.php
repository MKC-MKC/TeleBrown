<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class ChatInviteLink extends ResponseWrapper
{

	/**
	 * Метод возвращает ссылку-приглашение.
	 *
	 * @return string
	 */
	public function getInviteLink(): string
	{
		return (string)$this->getData("invite_link");
	}

	/**
	 * Метод возвращает создателя ссылки.
	 *
	 * @return User
	 */
	public function getCreator(): User
	{
		return new User((array)$this->getData("creator", []));
	}

	/**
	 * Метод сообщает, требует ли вступление одобрения администратора.
	 *
	 * @return bool
	 */
	public function createsJoinRequest(): bool
	{
		return (bool)$this->getData("creates_join_request");
	}

	/**
	 * Метод сообщает, является ли ссылка основной.
	 *
	 * @return bool
	 */
	public function isPrimary(): bool
	{
		return (bool)$this->getData("is_primary");
	}

	/**
	 * Метод сообщает, отозвана ли ссылка.
	 *
	 * @return bool
	 */
	public function isRevoked(): bool
	{
		return (bool)$this->getData("is_revoked");
	}

	/**
	 * Метод возвращает имя ссылки при его наличии.
	 *
	 * @return string|null
	 */
	public function getName(): string|null
	{
		$value = $this->getData("name");

		return $value === null ? null : (string)$value;
	}

	/**
	 * Метод возвращает время истечения ссылки при его наличии.
	 *
	 * @return int|null
	 */
	public function getExpireDate(): int|null
	{
		$value = $this->getData("expire_date");

		return $value === null ? null : (int)$value;
	}

	/**
	 * Метод возвращает ограничение числа участников при его наличии.
	 *
	 * @return int|null
	 */
	public function getMemberLimit(): int|null
	{
		$value = $this->getData("member_limit");

		return $value === null ? null : (int)$value;
	}

	/**
	 * Метод возвращает число ожидающих запросов при его наличии.
	 *
	 * @return int|null
	 */
	public function getPendingJoinRequestCount(): int|null
	{
		$value = $this->getData("pending_join_request_count");

		return $value === null ? null : (int)$value;
	}

	/**
	 * Метод возвращает период подписки в секундах при его наличии.
	 *
	 * @return int|null
	 */
	public function getSubscriptionPeriod(): int|null
	{
		$value = $this->getData("subscription_period");

		return $value === null ? null : (int)$value;
	}

	/**
	 * Метод возвращает стоимость подписки в Telegram Stars при её наличии.
	 *
	 * @return int|null
	 */
	public function getSubscriptionPrice(): int|null
	{
		$value = $this->getData("subscription_price");

		return $value === null ? null : (int)$value;
	}

}
