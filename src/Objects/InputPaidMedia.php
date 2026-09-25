<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class InputPaidMedia extends ResponseWrapper
{

	/**
	 * Тип платного медиа: photo, video или live_photo.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#inputpaidmediaphoto
	 */
	public function getType(): string
	{
		return (string)$this->getData("type");
	}

	/**
	 * Отправляемый файл: file_id, HTTP URL или attach://<file_attach_name>. Для live photo передаётся видео, отправка по URL не поддерживается.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#inputpaidmediaphoto
	 */
	public function getMedia(): string
	{
		return (string)$this->getData("media");
	}

	/**
	 * Необязательно. Миниатюра JPEG размером менее 200 кБ и не более 320 пикселей по каждой стороне. Загружается новым файлом через attach://<file_attach_name> и игнорируется без multipart/form-data.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputpaidmediavideo
	 */
	public function getThumbnail(): string|null
	{
		return $this->getData("thumbnail");
	}

	/**
	 * Необязательно. Обложка видео: file_id, HTTP URL или attach://<file_attach_name>.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputpaidmediavideo
	 */
	public function getCover(): string|null
	{
		return $this->getData("cover");
	}

	/**
	 * Необязательно. Начальная отметка времени видео в сообщении.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#inputpaidmediavideo
	 */
	public function getStartTimestamp(): int|null
	{
		return $this->getData("start_timestamp");
	}

	/**
	 * Необязательно. Ширина видео или анимации.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#inputpaidmediavideo
	 */
	public function getWidth(): int|null
	{
		return $this->getData("width");
	}

	/**
	 * Необязательно. Высота видео или анимации.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#inputpaidmediavideo
	 */
	public function getHeight(): int|null
	{
		return $this->getData("height");
	}

	/**
	 * Необязательно. Продолжительность медиа в секундах.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#inputpaidmediavideo
	 */
	public function getDuration(): int|null
	{
		return $this->getData("duration");
	}

	/**
	 * Необязательно. True, если загружаемое видео подходит для потокового воспроизведения.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#inputpaidmediavideo
	 */
	public function isSupportsStreaming(): bool
	{
		return (bool)$this->getData("supports_streaming", false);
	}

	/**
	 * Статическая фотография. Передайте file_id или attach://<file_attach_name>; отправка live photo по URL не поддерживается.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputpaidmedialivephoto
	 */
	public function getPhoto(): string|null
	{
		return $this->getData("photo");
	}

}
