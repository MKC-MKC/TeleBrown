<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * SharedUser – This object contains information about a user that was shared with the bot using a KeyboardButtonRequestUsers button.
 * @see https://core.telegram.org/bots/api#shareduser
 */
class SharedUser extends Type
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	public function getUserId(): int
	{
		return (int)$this->getData("user_id") ?? 0;
	}

	public function getFirstName(): string
	{
		return (string)$this->getData("first_name") ?? "";
	}

	public function getLastName(): string
	{
		return (string)$this->getData("last_name") ?? "";
	}

	public function getUsername(): string
	{
		return (string)$this->getData("username") ?? "";
	}

	public function getPhoto(): array
	{
		return $this->getData("photo") ?? [];
	}

}
