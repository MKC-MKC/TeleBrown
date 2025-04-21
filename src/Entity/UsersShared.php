<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * UsersShared – This object contains information about the users whose identifiers were shared with the bot using a KeyboardButtonRequestUsers button.
 * @see https://core.telegram.org/bots/api#usersshared
 */
class UsersShared
{
	private array $response;

	public function __construct(array $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array
	{
		return $this->response ?? [];
	}

	public function getRequestId(): int
	{
		return (int)$this->getAsArray()["request_id"] ?? 0;
	}

	public function getUsers(): array
	{
		return $this->getAsArray()["users"] ?? [];
	}

}
