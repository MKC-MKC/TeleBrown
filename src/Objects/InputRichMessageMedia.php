<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class InputRichMessageMedia extends ResponseWrapper
{

	/**
	 * Идентификатор медиа в ссылке tg://photo?id=, tg://video?id=, tg://document?id= или tg://audio?id=.
	 * От 1 до 64 символов: A-Z, a-z, 0-9, подчёркивание и дефис.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#inputrichmessagemedia
	 */
	public function getId(): string
	{
		return (string)$this->getData("id");
	}

	/**
	 * Медиа для отправки: анимация, аудио, документ, фотография, видео или голосовое сообщение.
	 * Все поля, кроме самого медиа и его свойств, игнорируются.
	 *
	 * @return InputMedia
	 * @see https://core.telegram.org/bots/api#inputrichmessagemedia
	 */
	public function getMedia(): InputMedia
	{
		return new InputMedia($this->getData("media"));
	}

}
