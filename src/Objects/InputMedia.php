<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class InputMedia extends ResponseWrapper
{

	/**
	 * Тип медиа: animation, audio, document, live_photo, photo или video.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#inputmedia
	 */
	public function getType(): string
	{
		return (string)$this->getData("type");
	}

	/**
	 * Отправляемый файл. Передайте file_id, HTTP URL или attach://<file_attach_name>.
	 * Для live photo передаётся видео; отправка live photo по URL не поддерживается.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#inputmedia
	 */
	public function getMedia(): string
	{
		return (string)$this->getData("media");
	}

	/**
	 * Необязательно. Подпись медиа, от 0 до 1024 символов после разбора сущностей.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputmedia
	 */
	public function getCaption(): string|null
	{
		return $this->getData("caption");
	}

	/**
	 * Необязательно. Режим разбора сущностей в подписи медиа.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputmedia
	 */
	public function getParseMode(): string|null
	{
		return $this->getData("parse_mode");
	}

	/**
	 * Необязательно. Список сущностей подписи, который можно указать вместо parse_mode.
	 *
	 * @return array|null
	 * @see https://core.telegram.org/bots/api#inputmedia
	 */
	public function getCaptionEntities(): array|null
	{
		return $this->getData("caption_entities");
	}

}
