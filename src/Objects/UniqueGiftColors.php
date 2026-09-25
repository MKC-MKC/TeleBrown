<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class UniqueGiftColors extends ResponseWrapper
{

	/**
	 * Идентификатор эмодзи модели уникального подарка.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#uniquegiftcolors
	 */
	public function getModelCustomEmojiId(): string
	{
		return (string)$this->getData("model_custom_emoji_id");
	}

	/**
	 * Идентификатор эмодзи символа уникального подарка.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#uniquegiftcolors
	 */
	public function getSymbolCustomEmojiId(): string
	{
		return (string)$this->getData("symbol_custom_emoji_id");
	}

	/**
	 * Основной цвет светлой темы в формате RGB.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#uniquegiftcolors
	 */
	public function getLightThemeMainColor(): int
	{
		return (int)$this->getData("light_theme_main_color");
	}

	/**
	 * От одного до трёх дополнительных цветов светлой темы в формате RGB.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#uniquegiftcolors
	 */
	public function getLightThemeOtherColors(): array
	{
		return (array)$this->getData("light_theme_other_colors", []);
	}

	/**
	 * Основной цвет тёмной темы в формате RGB.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#uniquegiftcolors
	 */
	public function getDarkThemeMainColor(): int
	{
		return (int)$this->getData("dark_theme_main_color");
	}

	/**
	 * От одного до трёх дополнительных цветов тёмной темы в формате RGB.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#uniquegiftcolors
	 */
	public function getDarkThemeOtherColors(): array
	{
		return (array)$this->getData("dark_theme_other_colors", []);
	}

}
