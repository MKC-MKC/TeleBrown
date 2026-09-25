<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class Community extends ResponseWrapper
{

	/**
	 * Уникальный идентификатор сообщества.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#community
	 */
	public function getId(): int
	{
		return (int)$this->getData("id");
	}

	/**
	 * Название сообщества.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#community
	 */
	public function getName(): string
	{
		return (string)$this->getData("name");
	}

}
