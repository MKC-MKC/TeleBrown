<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * WebAppInfo – Describes a Web App.
 * @see https://core.telegram.org/bots/api#webappinfo
 */
class WebAppInfo
{
	private array $response;

	public function __construct(array $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array
	{
		return $this->response ?? [];
	}

	public function getUrl(): string
	{
		return (string)$this->getAsArray()["url"] ?? "";
	}

}
