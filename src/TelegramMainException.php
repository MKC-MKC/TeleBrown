<?php

namespace Haikiri\TeleBrown;

use InvalidArgumentException;

class TelegramMainException extends InvalidArgumentException
{

	public function __construct(string $message = "Unknown error", int $code = 0)
	{
		parent::__construct($message, $code);
	}

}
