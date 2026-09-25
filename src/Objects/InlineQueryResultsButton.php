<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class InlineQueryResultsButton extends ResponseWrapper
{

	/**
	 * Текст на кнопке.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#inlinequeryresultsbutton
	 */
	public function getText(): string
	{
		return (string)$this->getData("text");
	}

	/**
	 * Необязательно. Веб-приложение, которое будет запущено при нажатии на кнопку.
	 * Приложение сможет вернуться в inline-режим с помощью метода switchInlineQuery.
	 * Используется ровно одно из полей web_app и start_parameter.
	 *
	 * @return WebAppInfo
	 * @see https://core.telegram.org/bots/api#inlinequeryresultsbutton
	 */
	public function getWebApp(): WebAppInfo
	{
		return new WebAppInfo($this->getData("web_app"));
	}

	/**
	 * Необязательно. Параметр команды /start, отправляемой боту при нажатии на кнопку.
	 * От 1 до 64 символов, допустимы A-Z, a-z, 0-9, подчёркивание и дефис.
	 * Используется ровно одно из полей web_app и start_parameter.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inlinequeryresultsbutton
	 */
	public function getStartParameter(): string|null
	{
		return $this->getData("start_parameter");
	}

}
