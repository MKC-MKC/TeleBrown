<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class StickerSet extends ResponseWrapper
{

	/**
	 * Имя набора стикеров.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#stickerset
	 */
	public function getName(): string
	{
		return (string)$this->getData("name");
	}

	/**
	 * Заголовок набора стикеров.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#stickerset
	 */
	public function getTitle(): string
	{
		return (string)$this->getData("title");
	}

	/**
	 * Тип стикеров: regular, mask или custom_emoji.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#stickerset
	 */
	public function getStickerType(): string
	{
		return (string)$this->getData("sticker_type");
	}

	/**
	 * Список всех стикеров набора.
	 *
	 * @return Sticker[]
	 * @see https://core.telegram.org/bots/api#stickerset
	 */
	public function getStickers(): array
	{
		return array_map(static fn(array $item): Sticker => new Sticker($item), $this->getData("stickers", []));
	}

	/**
	 * Необязательно. Миниатюра набора в формате WEBP, TGS или WEBM.
	 *
	 * @return PhotoSize|null
	 * @see https://core.telegram.org/bots/api#stickerset
	 */
	public function getThumbnail(): PhotoSize|null
	{
		$data = $this->getData("thumbnail");
		return $data === null ? null : new PhotoSize($data);
	}

}
