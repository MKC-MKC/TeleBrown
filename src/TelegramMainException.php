<?php

namespace Haikiri\TeleBrown;

use LogicException;

class TelegramMainException extends LogicException
{

	public function __construct(string $message = "Unknown error", int $code = 0)
	{
		parent::__construct($message, $code);
	}

}
