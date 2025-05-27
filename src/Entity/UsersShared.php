<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * UsersShared – This object contains information about the users whose identifiers were shared with the bot using a KeyboardButtonRequestUsers button.
 * @see https://core.telegram.org/bots/api#usersshared
 */
class UsersShared extends ResponseWrapper
{

	public function getRequestId(): int
	{
		return (int)$this->getData("request_id");
	}

	public function getUsers(): array
	{
		return (array)$this->getData("users");
	}

}
