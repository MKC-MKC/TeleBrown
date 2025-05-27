<?php

namespace Haikiri\TeleBrown\Exceptions;

use LogicException;

class TelegramMainException extends LogicException
{

	public function __construct(string $message = "Unknown error", int $code = -1)
	{
		parent::__construct($message, $code);
	}

}
