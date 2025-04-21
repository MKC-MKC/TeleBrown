<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

class ChatBoostUpdated
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

}
