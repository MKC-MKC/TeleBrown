<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * KeyboardButtonRequestUsers – This object defines the criteria used to request suitable users.
 * Information about the selected users will be shared with the bot when the corresponding button is pressed.
 * @see https://core.telegram.org/bots/api#keyboardbuttonrequestusers
 */
class KeyboardButtonRequestUsers extends Type
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

	public function isUserIsBot(): bool
	{
		return ($this->getData("user_is_bot") ?? false);
	}

	public function isUserIsPremium(): bool
	{
		return ($this->getData("user_is_premium") ?? false);
	}

	public function getMaxQuantity(): int
	{
		return (int)$this->getData("max_quantity") ?? 0;
	}

	public function isRequestName(): bool
	{
		return ($this->getData("request_name") ?? false);
	}

	public function isRequestUsername(): bool
	{
		return ($this->getData("request_username") ?? false);
	}

	public function isRequestPhoto(): bool
	{
		return ($this->getData("request_photo") ?? false);
	}

}
