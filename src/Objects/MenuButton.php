<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class MenuButton extends ResponseWrapper
{

	/**
	 * Тип кнопки меню: commands, web_app или default.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#menubutton
	 */
	public function getType(): string
	{
		return (string)$this->getData("type");
	}

	/**
	 * Текст кнопки для типа web_app.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#menubutton
	 */
	public function getText(): string|null
	{
		return $this->getData("text");
	}

	/**
	 * Веб-приложение, открываемое кнопкой типа web_app.
	 *
	 * @return WebAppInfo|null
	 * @see https://core.telegram.org/bots/api#menubutton
	 */
	public function getWebApp(): WebAppInfo|null
	{
		$data = $this->getData("web_app");
		return $data === null ? null : new WebAppInfo($data);
	}

}
