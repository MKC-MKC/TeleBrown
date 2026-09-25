<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class ManagedBotUpdated extends ResponseWrapper
{

	/**
	 * Пользователь, создавший бота.
	 *
	 * @return User
	 * @see https://core.telegram.org/bots/api#managedbotupdated
	 */
	public function getUser(): User
	{
		$data = $this->getData("user");
		return new User($data);
	}

	/**
	 * Сведения о боте; его токен можно получить через getManagedBotToken.
	 *
	 * @return User
	 * @see https://core.telegram.org/bots/api#managedbotupdated
	 */
	public function getBot(): User
	{
		$data = $this->getData("bot");
		return new User($data);
	}

}
