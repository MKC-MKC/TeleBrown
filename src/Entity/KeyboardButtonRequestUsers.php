<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * KeyboardButtonRequestUsers – This object defines the criteria used to request suitable users.
 * Information about the selected users will be shared with the bot when the corresponding button is pressed.
 * @see https://core.telegram.org/bots/api#keyboardbuttonrequestusers
 */
class KeyboardButtonRequestUsers
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

	public function isUserIsBot(): bool
	{
		return ($this->getAsArray()["user_is_bot"] ?? false);
	}

	public function isUserIsPremium(): bool
	{
		return ($this->getAsArray()["user_is_premium"] ?? false);
	}

	public function getMaxQuantity(): int
	{
		return (int)$this->getAsArray()["max_quantity"] ?? 0;
	}

	public function isRequestName(): bool
	{
		return ($this->getAsArray()["request_name"] ?? false);
	}

	public function isRequestUsername(): bool
	{
		return ($this->getAsArray()["request_username"] ?? false);
	}

	public function isRequestPhoto(): bool
	{
		return ($this->getAsArray()["request_photo"] ?? false);
	}

}
