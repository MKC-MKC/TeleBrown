<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class ReactionType extends ResponseWrapper
{

	/**
	 * Метод возвращает вид реакции.
	 *
	 * @return string
	 */
	public function getType(): string
	{
		return (string)$this->getData("type");
	}

	/**
	 * Метод возвращает обычный emoji реакции при его наличии.
	 *
	 * @return string|null
	 */
	public function getEmoji(): string|null
	{
		$value = $this->getData("emoji");

		return $value === null ? null : (string)$value;
	}

	/**
	 * Метод возвращает идентификатор пользовательского emoji при его наличии.
	 *
	 * @return string|null
	 */
	public function getCustomEmojiId(): string|null
	{
		$value = $this->getData("custom_emoji_id");

		return $value === null ? null : (string)$value;
	}

}
