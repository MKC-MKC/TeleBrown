<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * SharedUser – This object contains information about a user that was shared with the bot using a KeyboardButtonRequestUsers button.
 * @see https://core.telegram.org/bots/api#shareduser
 */
class SharedUser
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

	public function getUserId(): int
	{
		return (int)$this->getAsArray()["user_id"] ?? 0;
	}

	public function getFirstName(): string
	{
		return (string)$this->getAsArray()["first_name"] ?? "";
	}

	public function getLastName(): string
	{
		return (string)$this->getAsArray()["last_name"] ?? "";
	}

	public function getUsername(): string
	{
		return (string)$this->getAsArray()["username"] ?? "";
	}

	public function getPhoto(): array
	{
		return $this->getAsArray()["photo"] ?? [];
	}

}
