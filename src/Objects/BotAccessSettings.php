<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class BotAccessSettings extends ResponseWrapper
{

	/**
	 * True, если доступ разрешён только выбранным пользователям. Владелец всегда имеет доступ.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#botaccesssettings
	 */
	public function isAccessRestricted(): bool
	{
		return (bool)$this->getData("is_access_restricted");
	}

	/**
	 * Необязательно. Другие пользователи, которым разрешён доступ при включённых ограничениях.
	 *
	 * @return User[]
	 * @see https://core.telegram.org/bots/api#botaccesssettings
	 */
	public function getAddedUsers(): array
	{
		return array_map(static fn(array $item): User => new User($item), $this->getData("added_users", []));
	}

}
