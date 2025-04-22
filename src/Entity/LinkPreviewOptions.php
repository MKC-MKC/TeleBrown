<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * MessageEntity – Describes the options used for link preview generation.
 * @see https://core.telegram.org/bots/api#linkpreviewoptions
 */
class LinkPreviewOptions extends Type
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	/**
	 * Опционально. true, если предпросмотр ссылки отключен
	 * Optional. True, if the link preview is disabled
	 *
	 * @return bool
	 */
	public function isDisabled(): bool
	{
		return ($this->getData("is_disabled") ?? false);
	}

	/**
	 * Опционально. URL, который будет использоваться для превью ссылки.
	 * Если пусто, то будет использоваться первый URL, найденный в тексте сообщения
	 *
	 * Optional. URL to use for the link preview.
	 * If empty, then the first URL found in the message text will be used
	 *
	 * @return string
	 */
	public function getUrl(): string
	{
		return (string)$this->getData("url") ?? "";
	}

	/**
	 * Опционально. true, если предпросмотр ссылки должен быть уменьшен;
	 * игнорируется, если URL не указан явно или изменение размера медиафайла не поддерживается для превью
	 *
	 * Optional. True, if the media in the link preview is supposed to be shrunk;
	 * ignored if the URL isn't explicitly specified or media size change isn't supported for the preview
	 *
	 * @return bool
	 */
	public function isPreferSmallMedia(): bool
	{
		return ($this->getData("prefer_small_media") ?? false);
	}

	/**
	 * Опционально. true, если предпросмотр ссылки должен быть увеличен;
	 * игнорируется, если URL не указан явно или изменение размера медиафайла не поддерживается для превью
	 *
	 * Optional. True, if the media in the link preview is supposed to be enlarged;
	 * ignored if the URL isn't explicitly specified or media size change isn't supported for the preview
	 *
	 * @return bool
	 */
	public function isPreferLargeMedia(): bool
	{
		return ($this->getData("prefer_large_media") ?? false);
	}

	/**
	 * Опционально. true, если предпросмотр ссылки должен быть показан над текстом сообщения;
	 * иначе предпросмотр ссылки будет показан под текстом сообщения
	 *
	 * Optional. True, if the link preview must be shown above the message text;
	 * otherwise, the link preview will be shown below the message text
	 *
	 * @return bool
	 */
	public function isShowAboveText(): bool
	{
		return ($this->getData("show_above_text") ?? false);
	}

}
