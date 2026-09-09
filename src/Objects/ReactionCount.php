<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class ReactionCount extends ResponseWrapper
{

	/**
	 * Метод возвращает вид реакции.
	 *
	 * @return ReactionType
	 */
	public function getType(): ReactionType
	{
		return new ReactionType((array)$this->getData("type", []));
	}

	/**
	 * Метод возвращает количество реакций этого вида.
	 *
	 * @return int
	 */
	public function getTotalCount(): int
	{
		return (int)$this->getData("total_count");
	}

}
