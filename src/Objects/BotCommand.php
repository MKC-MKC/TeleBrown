<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class BotCommand extends ResponseWrapper
{

	/**
	 * Текст команды, 1-32 символа: строчные английские буквы, цифры и подчёркивания.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#botcommand
	 */
	public function getCommand(): string
	{
		return (string)$this->getData("command");
	}

	/**
	 * Описание команды, 1-256 символов.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#botcommand
	 */
	public function getDescription(): string
	{
		return (string)$this->getData("description");
	}

	/**
	 * Необязательно. True, если команда отправляет сообщение, видимое только отправителю и боту.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#botcommand
	 */
	public function isEphemeral(): bool
	{
		return (bool)$this->getData("is_ephemeral", false);
	}

}
