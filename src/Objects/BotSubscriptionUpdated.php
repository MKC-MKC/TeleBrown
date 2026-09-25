<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class BotSubscriptionUpdated extends ResponseWrapper
{

	/**
	 * Пользователь, оформивший подписку для платежей боту.
	 *
	 * @return User
	 * @see https://core.telegram.org/bots/api#botsubscriptionupdated
	 */
	public function getUser(): User
	{
		$data = $this->getData("user");
		return new User($data);
	}

	/**
	 * Указанные ботом данные счёта.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#botsubscriptionupdated
	 */
	public function getInvoicePayload(): string
	{
		return (string)$this->getData("invoice_payload");
	}

	/**
	 * Новое состояние подписки: canceled, active или failed.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#botsubscriptionupdated
	 */
	public function getState(): string
	{
		return (string)$this->getData("state");
	}

}
