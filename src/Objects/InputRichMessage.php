<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class InputRichMessage extends ResponseWrapper
{

	/**
	 * Необязательно. Содержимое rich-сообщения в виде списка блоков.
	 *
	 * @return array|null
	 * @see https://core.telegram.org/bots/api#inputrichmessage
	 */
	public function getBlocks(): array|null
	{
		return $this->getData("blocks");
	}

	/**
	 * Необязательно. Содержимое rich-сообщения с форматированием HTML.
	 * Используйте поле media, чтобы указать медиафайлы сообщения.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputrichmessage
	 */
	public function getHtml(): string|null
	{
		return $this->getData("html");
	}

	/**
	 * Необязательно. Содержимое rich-сообщения с форматированием Markdown.
	 * Используйте поле media, чтобы указать медиафайлы сообщения.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputrichmessage
	 */
	public function getMarkdown(): string|null
	{
		return $this->getData("markdown");
	}

	/**
	 * Необязательно. Список медиафайлов, указанных в полях markdown или html
	 * ссылками tg://photo?id=, tg://video?id=, tg://document?id= и tg://audio?id=.
	 *
	 * @return array|null
	 * @see https://core.telegram.org/bots/api#inputrichmessage
	 */
	public function getMedia(): array|null
	{
		return $this->getData("media");
	}

	/**
	 * Необязательно. Передайте True, если rich-сообщение должно отображаться справа налево.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#inputrichmessage
	 */
	public function isRtl(): bool
	{
		return (bool)$this->getData("is_rtl");
	}

	/**
	 * Необязательно. Передайте True, чтобы пропустить автоматическое обнаружение сущностей в тексте.
	 * Например, URL, адресов электронной почты, упоминаний, хештегов, команд бота и номеров телефона.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#inputrichmessage
	 */
	public function isSkipEntityDetection(): bool
	{
		return (bool)$this->getData("skip_entity_detection");
	}

}
