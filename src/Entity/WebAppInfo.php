<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * WebAppInfo – Describes a Web App.
 * @see https://core.telegram.org/bots/api#webappinfo
 */
class WebAppInfo extends Type
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	public function getUrl(): string
	{
		return (string)$this->getData("url") ?? "";
	}

}
