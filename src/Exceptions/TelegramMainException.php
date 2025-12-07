<?php

namespace Haikiri\TeleBrown\Exceptions;

use LogicException;
use Throwable;

class TelegramMainException extends LogicException
{

	public function __construct(string $message = "Unknown error", int $code = -1, ?Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}

}
