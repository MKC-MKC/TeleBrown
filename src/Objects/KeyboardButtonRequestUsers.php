<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * KeyboardButtonRequestUsers – This object defines the criteria used to request suitable users.
 * Information about the selected users will be shared with the bot when the corresponding button is pressed.
 * @see https://core.telegram.org/bots/api#keyboardbuttonrequestusers
 */
class KeyboardButtonRequestUsers extends ResponseWrapper
{

	public function getRequestId(): int
	{
		return (int)$this->getData("request_id");
	}

	public function isUserIsBot(): bool
	{
		return (bool)$this->getData("user_is_bot");
	}

	public function isUserIsPremium(): bool
	{
		return (bool)$this->getData("user_is_premium");
	}

	public function getMaxQuantity(): int
	{
		return (int)$this->getData("max_quantity");
	}

	public function isRequestName(): bool
	{
		return (bool)$this->getData("request_name");
	}

	public function isRequestUsername(): bool
	{
		return (bool)$this->getData("request_username");
	}

	public function isRequestPhoto(): bool
	{
		return (bool)$this->getData("request_photo");
	}

}
