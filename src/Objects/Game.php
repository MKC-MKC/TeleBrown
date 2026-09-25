<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class Game extends ResponseWrapper
{

	/**
	 * Название игры.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#game
	 */
	public function getTitle(): string
	{
		return (string)$this->getData("title");
	}

	/**
	 * Описание игры.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#game
	 */
	public function getDescription(): string
	{
		return (string)$this->getData("description");
	}

	/**
	 * Фотография, отображаемая в сообщении с игрой.
	 *
	 * @return PhotoSize[]
	 * @see https://core.telegram.org/bots/api#game
	 */
	public function getPhoto(): array
	{
		return array_map(static fn(array $item): PhotoSize => new PhotoSize($item), (array)$this->getData("photo", []));
	}

	/**
	 * Необязательно. Краткое описание или лучшие результаты игры, от 0 до 4096 символов.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#game
	 */
	public function getText(): string|null
	{
		return $this->getData("text");
	}

	/**
	 * Необязательно. Специальные сущности в тексте: имена пользователей, URL, команды бота и другие.
	 *
	 * @return MessageEntity[]
	 * @see https://core.telegram.org/bots/api#game
	 */
	public function getTextEntities(): array
	{
		return array_map(static fn(array $item): MessageEntity => new MessageEntity($item), (array)$this->getData("text_entities", []));
	}

	/**
	 * Необязательно. Анимация в сообщении с игрой; загружается через BotFather.
	 *
	 * @return Animation|null
	 * @see https://core.telegram.org/bots/api#game
	 */
	public function getAnimation(): Animation|null
	{
		$data = $this->getData("animation");
		return $data === null ? null : new Animation($data);
	}

}
