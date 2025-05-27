<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * WebAppInfo – Describes a Web App.
 * @see https://core.telegram.org/bots/api#webappinfo
 */
class WebAppInfo extends ResponseWrapper
{

	public function getUrl(): string
	{
		return (string)$this->getData("url");
	}

}
