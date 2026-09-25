<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class PollMedia extends ResponseWrapper
{

	/**
	 * Необязательно. Медиа является анимацией; сведения об анимации.
	 *
	 * @return Animation|null
	 * @see https://core.telegram.org/bots/api#pollmedia
	 */
	public function getAnimation(): Animation|null
	{
		$data = $this->getData("animation");
		return $data === null ? null : new Animation($data);
	}

	/**
	 * Необязательно. Медиа является аудиофайлом; сведения о файле.
	 *
	 * @return Audio|null
	 * @see https://core.telegram.org/bots/api#pollmedia
	 */
	public function getAudio(): Audio|null
	{
		$data = $this->getData("audio");
		return $data === null ? null : new Audio($data);
	}

	/**
	 * Необязательно. Медиа является документом; сведения о файле.
	 *
	 * @return Document|null
	 * @see https://core.telegram.org/bots/api#pollmedia
	 */
	public function getDocument(): Document|null
	{
		$data = $this->getData("document");
		return $data === null ? null : new Document($data);
	}

	/**
	 * Необязательно. HTTP-ссылка, прикреплённая к варианту ответа.
	 *
	 * @return Link|null
	 * @see https://core.telegram.org/bots/api#pollmedia
	 */
	public function getLink(): Link|null
	{
		$data = $this->getData("link");
		return $data === null ? null : new Link($data);
	}

	/**
	 * Необязательно. Медиа является живой фотографией; сведения о фотографии.
	 *
	 * @return LivePhoto|null
	 * @see https://core.telegram.org/bots/api#pollmedia
	 */
	public function getLivePhoto(): LivePhoto|null
	{
		$data = $this->getData("live_photo");
		return $data === null ? null : new LivePhoto($data);
	}

	/**
	 * Необязательно. Медиа является геопозицией; сведения о местоположении.
	 *
	 * @return Location|null
	 * @see https://core.telegram.org/bots/api#pollmedia
	 */
	public function getLocation(): Location|null
	{
		$data = $this->getData("location");
		return $data === null ? null : new Location($data);
	}

	/**
	 * Необязательно. Медиа является фотографией; доступные размеры.
	 *
	 * @return PhotoSize[]
	 * @see https://core.telegram.org/bots/api#pollmedia
	 */
	public function getPhoto(): array
	{
		return array_map(static fn(array $item): PhotoSize => new PhotoSize($item), (array)$this->getData("photo", []));
	}

	/**
	 * Необязательно. Медиа является стикером; только для вариантов ответа.
	 *
	 * @return Sticker|null
	 * @see https://core.telegram.org/bots/api#pollmedia
	 */
	public function getSticker(): Sticker|null
	{
		$data = $this->getData("sticker");
		return $data === null ? null : new Sticker($data);
	}

	/**
	 * Необязательно. Медиа является заведением; сведения о заведении.
	 *
	 * @return Venue|null
	 * @see https://core.telegram.org/bots/api#pollmedia
	 */
	public function getVenue(): Venue|null
	{
		$data = $this->getData("venue");
		return $data === null ? null : new Venue($data);
	}

	/**
	 * Необязательно. Медиа является видео; сведения о видео.
	 *
	 * @return Video|null
	 * @see https://core.telegram.org/bots/api#pollmedia
	 */
	public function getVideo(): Video|null
	{
		$data = $this->getData("video");
		return $data === null ? null : new Video($data);
	}

}
