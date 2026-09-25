<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class Link extends ResponseWrapper
{

	/**
	 * URL ссылки.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#link
	 */
	public function getUrl(): string
	{
		return (string)$this->getData("url");
	}

}
