<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class InputPollOption extends ResponseWrapper
{

	/**
	 * Текст варианта ответа, 1-100 символов.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#inputpolloption
	 */
	public function getText(): string
	{
		return (string)$this->getData("text");
	}

	/**
	 * Необязательно. Режим разбора сущностей в тексте варианта ответа. Допускаются только пользовательские эмодзи.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#inputpolloption
	 */
	public function getTextParseMode(): string|null
	{
		return $this->getData("text_parse_mode");
	}

	/**
	 * Необязательно. Сущности текста, которые можно указать вместо режима разбора.
	 *
	 * @return MessageEntity[]
	 * @see https://core.telegram.org/bots/api#inputpolloption
	 */
	public function getTextEntities(): array
	{
		return array_map(static fn(array $item): MessageEntity => new MessageEntity($item), $this->getData("text_entities", []));
	}

	/**
	 * Необязательно. Медиа, добавленное к варианту ответа.
	 *
	 * @return InputPollMedia|null
	 * @see https://core.telegram.org/bots/api#inputpolloption
	 */
	public function getMedia(): InputPollMedia|null
	{
		$data = $this->getData("media");
		return $data === null ? null : new InputPollMedia($data);
	}

}
