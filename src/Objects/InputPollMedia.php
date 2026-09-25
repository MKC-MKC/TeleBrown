<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class InputPollMedia extends ResponseWrapper
{

	/**
	 * Тип содержимого: animation, audio, document, live_photo, location, photo, venue, video, link или sticker.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#inputmediaanimation
	 */
	public function getType(): string
	{
		return (string)$this->getData("type");
	}

	/**
	 * Отправляемый файл: file_id, HTTP URL или attach://<file_attach_name>. Для live photo передаётся видео, отправка по URL не поддерживается.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputmediaanimation
	 */
	public function getMedia(): string|null
	{
		return $this->getData("media");
	}

	/**
	 * Необязательно. Миниатюра JPEG размером менее 200 кБ и не более 320 пикселей по каждой стороне. Загружается новым файлом через attach://<file_attach_name> и игнорируется без multipart/form-data.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputmediaanimation
	 */
	public function getThumbnail(): string|null
	{
		return $this->getData("thumbnail");
	}

	/**
	 * Необязательно. Подпись медиа, 0-1024 символа после разбора сущностей.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputmediaanimation
	 */
	public function getCaption(): string|null
	{
		return $this->getData("caption");
	}

	/**
	 * Необязательно. Режим разбора сущностей в тексте.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputmediaanimation
	 */
	public function getParseMode(): string|null
	{
		return $this->getData("parse_mode");
	}

	/**
	 * Необязательно. Сущности подписи, которые можно указать вместо parse_mode.
	 *
	 * @return MessageEntity[]
	 * @see https://core.telegram.org/bots/api#inputmediaanimation
	 */
	public function getCaptionEntities(): array
	{
		return array_map(static fn(array $item): MessageEntity => new MessageEntity($item), $this->getData("caption_entities", []));
	}

	/**
	 * Необязательно. True, если подпись должна отображаться над медиа.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#inputmediaanimation
	 */
	public function getShowCaptionAboveMedia(): bool
	{
		return (bool)$this->getData("show_caption_above_media", false);
	}

	/**
	 * Необязательно. Ширина видео или анимации.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#inputmediaanimation
	 */
	public function getWidth(): int|null
	{
		return $this->getData("width");
	}

	/**
	 * Необязательно. Высота видео или анимации.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#inputmediaanimation
	 */
	public function getHeight(): int|null
	{
		return $this->getData("height");
	}

	/**
	 * Необязательно. Продолжительность медиа в секундах.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#inputmediaanimation
	 */
	public function getDuration(): int|null
	{
		return $this->getData("duration");
	}

	/**
	 * Необязательно. True, если медиа нужно скрыть анимацией спойлера.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#inputmediaanimation
	 */
	public function hasSpoiler(): bool
	{
		return (bool)$this->getData("has_spoiler", false);
	}

	/**
	 * Необязательно. Исполнитель аудиозаписи.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputmediaaudio
	 */
	public function getPerformer(): string|null
	{
		return $this->getData("performer");
	}

	/**
	 * Необязательно для аудио: название записи. Для venue: название места.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputmediaaudio
	 */
	public function getTitle(): string|null
	{
		return $this->getData("title");
	}

	/**
	 * Необязательно. Отключаем определение типа содержимого файла на сервере при загрузке через multipart/form-data. Всегда True для документа в альбоме.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#inputmediadocument
	 */
	public function getDisableContentTypeDetection(): bool
	{
		return (bool)$this->getData("disable_content_type_detection", false);
	}

	/**
	 * Статическая фотография. Передайте file_id или attach://<file_attach_name>; отправка live photo по URL не поддерживается.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputmedialivephoto
	 */
	public function getPhoto(): string|null
	{
		return $this->getData("photo");
	}

	/**
	 * Широта местоположения.
	 *
	 * @return float|null
	 * @see https://core.telegram.org/bots/api#inputmedialocation
	 */
	public function getLatitude(): float|null
	{
		return $this->getData("latitude");
	}

	/**
	 * Долгота местоположения.
	 *
	 * @return float|null
	 * @see https://core.telegram.org/bots/api#inputmedialocation
	 */
	public function getLongitude(): float|null
	{
		return $this->getData("longitude");
	}

	/**
	 * Необязательно. Радиус неопределённости местоположения в метрах, 0-1500.
	 *
	 * @return float|null
	 * @see https://core.telegram.org/bots/api#inputmedialocation
	 */
	public function getHorizontalAccuracy(): float|null
	{
		return $this->getData("horizontal_accuracy");
	}

	/**
	 * Адрес места.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputmediavenue
	 */
	public function getAddress(): string|null
	{
		return $this->getData("address");
	}

	/**
	 * Необязательно. Идентификатор места в Foursquare.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputmediavenue
	 */
	public function getFoursquareId(): string|null
	{
		return $this->getData("foursquare_id");
	}

	/**
	 * Необязательно. Тип места в Foursquare, например food/icecream.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputmediavenue
	 */
	public function getFoursquareType(): string|null
	{
		return $this->getData("foursquare_type");
	}

	/**
	 * Необязательно. Идентификатор места в Google Places.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputmediavenue
	 */
	public function getGooglePlaceId(): string|null
	{
		return $this->getData("google_place_id");
	}

	/**
	 * Необязательно. Тип места в Google Places.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputmediavenue
	 */
	public function getGooglePlaceType(): string|null
	{
		return $this->getData("google_place_type");
	}

	/**
	 * Необязательно. Обложка видео: file_id, HTTP URL или attach://<file_attach_name>.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputmediavideo
	 */
	public function getCover(): string|null
	{
		return $this->getData("cover");
	}

	/**
	 * Необязательно. Начальная отметка времени видео в сообщении.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#inputmediavideo
	 */
	public function getStartTimestamp(): int|null
	{
		return $this->getData("start_timestamp");
	}

	/**
	 * Необязательно. True, если загружаемое видео подходит для потокового воспроизведения.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#inputmediavideo
	 */
	public function isSupportsStreaming(): bool
	{
		return (bool)$this->getData("supports_streaming", false);
	}

	/**
	 * HTTP URL ссылки.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputmedialink
	 */
	public function getUrl(): string|null
	{
		return $this->getData("url");
	}

	/**
	 * Необязательно. Эмодзи стикера; только для только что загруженных стикеров.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputmediasticker
	 */
	public function getEmoji(): string|null
	{
		return $this->getData("emoji");
	}

}
