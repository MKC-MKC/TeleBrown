<?php

namespace Haikiri\TeleBrown;

use Exception;

class TelegramMainException extends Exception
{

	public function __construct(string $message = "Unknown error", int $code = 0)
	{
		parent::__construct($message, $code);
	}

}
