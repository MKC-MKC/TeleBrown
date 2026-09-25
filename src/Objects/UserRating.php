<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class UserRating extends ResponseWrapper
{

	/**
	 * Текущий уровень пользователя, отражающий надёжность при покупке цифровых товаров и услуг.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#userrating
	 */
	public function getLevel(): int
	{
		return (int)$this->getData("level");
	}

	/**
	 * Числовое значение рейтинга пользователя; чем выше, тем лучше.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#userrating
	 */
	public function getRating(): int
	{
		return (int)$this->getData("rating");
	}

	/**
	 * Рейтинг, необходимый для текущего уровня.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#userrating
	 */
	public function getCurrentLevelRating(): int
	{
		return (int)$this->getData("current_level_rating");
	}

	/**
	 * Необязательно. Рейтинг для следующего уровня; отсутствует при достижении максимального уровня.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#userrating
	 */
	public function getNextLevelRating(): int|null
	{
		return $this->getData("next_level_rating");
	}

}
