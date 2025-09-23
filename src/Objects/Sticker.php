<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * Sticker – This object represents a sticker.
 * @see https://core.telegram.org/bots/api#sticker
 */
class Sticker extends ResponseWrapper
{

	/**
	 * Идентификатор файла, который можно использовать для загрузки или повторного использования файла
	 * Identifier for this file, which can be used to download or reuse the file
	 *
	 * @return string
	 */
	public function getFileId(): string
	{
		return (string)$this->getData("file_id");
	}

	/**
	 * Уникальный идентификатор для этого файла, который, как предполагается, остается неизменным с течением времени и для разных ботов.
	 * Не может быть использован для загрузки или повторного использования файла.
	 *
	 * Unique identifier for this file, which is supposed to be the same over time and for different bots.
	 * Can't be used to download or reuse the file.
	 *
	 * @return string
	 */
	public function getFileUniqueId(): string
	{
		return (string)$this->getData("file_unique_id");
	}

	/**
	 * Тип стикера, в настоящее время один из «regular», «mask», «custom_emoji».
	 * Тип стикера не зависит от его формата, который определяется полями is_animated и is_video.
	 *
	 * Type of the sticker, currently one of “regular”, “mask”, “custom_emoji”.
	 * The type of the sticker is independent from its format, which is determined by the fields is_animated and is_video.
	 *
	 * @return string
	 */
	public function getType(): string
	{
		return (string)$this->getData("type");
	}

	/**
	 * Ширина стикера
	 * Sticker width
	 *
	 * @return int
	 */
	public function getWidth(): int
	{
		return (int)$this->getData("width");
	}

	/**
	 * Высота стикера
	 * Sticker height
	 *
	 * @return int
	 */
	public function getHeight(): int
	{
		return (int)$this->getData("height");
	}

	/**
	 * True, если стикер анимированный
	 * True, if the sticker is animated
	 *
	 * @return bool
	 */
	public function isAnimated(): bool
	{
		return (bool)$this->getData("is_animated", false);
	}

	/**
	 * True, если стикер является видео стикером
	 * True, if the sticker is a video sticker
	 *
	 * @return bool
	 */
	public function isVideo(): bool
	{
		return (bool)$this->getData("is_video", false);
	}

	/**
	 * Опционально. Миниатюра стикера в формате .WEBP или .JPG
	 * Optional. Sticker thumbnail in the .WEBP or .JPG format
	 *
	 * @return PhotoSize
	 */
	public function getThumbnail(): PhotoSize
	{
		return new PhotoSize($this->getData("thumbnail"));
	}

	/**
	 * Опционально. Эмодзи, связанное со стикером
	 * Optional. Emoji associated with the sticker
	 *
	 * @return string|null
	 */
	public function getEmoji(): string|null
	{
		return $this->getData("emoji");
	}

	/**
	 * Опционально. Имя набора стикеров, к которому принадлежит стикер
	 * Optional. Name of the sticker set to which the sticker belongs
	 *
	 * @return string
	 */
	public function getSetName(): string
	{
		return (string)$this->getData("set_name");
	}

	/**
	 * Опционально. Для премиальных обычных стикеров, премиальная анимация для стикера
	 * Optional. For premium regular stickers, premium animation for the sticker
	 *
	 * @return File
	 */
	public function getPremiumAnimation(): File
	{
		return new File($this->getData("premium_animation"));
	}

	/**
	 * Опционально. Для масок стикеров, позиция, где должна быть размещена маска
	 * Optional. For mask stickers, the position where the mask should be placed
	 *
	 * @return MaskPosition
	 */
	public function getMaskPosition(): MaskPosition
	{
		return new MaskPosition($this->getData("mask_position"));
	}

	/**
	 * Опционально. Для стикеров с пользовательскими эмодзи, уникальный идентификатор пользовательского эмодзи
	 * Optional. For custom emoji stickers, unique identifier of the custom emoji
	 *
	 * @return string
	 */
	public function getCustomEmojiId(): string
	{
		return (string)$this->getData("custom_emoji_id");
	}

	/**
	 * Опционально. True, если стикер должен быть перекрашен в цвет текста в сообщениях,
	 * цвет значка Telegram Premium в статусе эмодзи, белый цвет на фотографиях чата или другой подходящий цвет в других местах
	 *
	 * Optional. True, if the sticker must be repainted to a text color in messages,
	 * the color of the Telegram Premium badge in emoji status, white color on chat photos, or another appropriate color in other places
	 *
	 * @return bool|null
	 */
	public function needsRepainting(): bool|null
	{
		return $this->getData("needs_repainting");
	}

	/**
	 * Опционально. Размер файла в байтах
	 * Optional. File size in bytes
	 *
	 * @return int|null
	 */
	public function getFileSize(): int|null
	{
		return $this->getData("file_size");
	}

}
