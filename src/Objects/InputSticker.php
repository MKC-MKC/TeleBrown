<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class InputSticker extends ResponseWrapper
{

	/**
	 * Добавляемый стикер: file_id, HTTP URL или attach://<file_attach_name>. Анимированные и видеостикеры нельзя загрузить по URL.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#inputsticker
	 */
	public function getSticker(): string
	{
		return (string)$this->getData("sticker");
	}

	/**
	 * Формат: static для WEBP/PNG, animated для TGS, video для WEBM.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#inputsticker
	 */
	public function getFormat(): string
	{
		return (string)$this->getData("format");
	}

	/**
	 * От 1 до 20 эмодзи, связанных со стикером.
	 *
	 * @return string[]
	 * @see https://core.telegram.org/bots/api#inputsticker
	 */
	public function getEmojiList(): array
	{
		return $this->getData("emoji_list", []);
	}

	/**
	 * Необязательно. Положение маски на лице; только для стикеров mask.
	 *
	 * @return MaskPosition|null
	 * @see https://core.telegram.org/bots/api#inputsticker
	 */
	public function getMaskPosition(): MaskPosition|null
	{
		$data = $this->getData("mask_position");
		return $data === null ? null : new MaskPosition($data);
	}

	/**
	 * Необязательно. От 0 до 20 ключевых слов общей длиной до 64 символов; только для regular и custom_emoji.
	 *
	 * @return string[]
	 * @see https://core.telegram.org/bots/api#inputsticker
	 */
	public function getKeywords(): array
	{
		return $this->getData("keywords", []);
	}

}
