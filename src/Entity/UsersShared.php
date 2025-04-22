<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * UsersShared – This object contains information about the users whose identifiers were shared with the bot using a KeyboardButtonRequestUsers button.
 * @see https://core.telegram.org/bots/api#usersshared
 */
class UsersShared extends Type
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	public function getRequestId(): int
	{
		return (int)$this->getData("request_id") ?? 0;
	}

	public function getUsers(): array
	{
		return $this->getData("users") ?? [];
	}

}
