<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;
use Haikiri\TeleBrown\Enums\InlineQueryChatEnum;

/**
 * InlineQuery – This object represents an incoming inline query. When the user sends an empty query, your bot could return some default or trending results.
 * @see https://core.telegram.org/bots/api#inlinequery
 */
class InlineQuery extends Type
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
	 * Уникальный идентификатор для этого запроса
	 * Unique identifier for this query
	 *
	 * @return string
	 */
	public function getId(): string
	{
		return (string)$this->getData("id") ?? "";
	}

	/**
	 * Отправитель
	 * Sender
	 *
	 * @return User
	 */
	public function getFrom(): User
	{
		return new User($this->getData("from") ?? null);
	}

	/**
	 * Текст запроса (до 256 символов)
	 * Text of the query (up to 256 characters)
	 *
	 * @return string
	 */
	public function getQuery(): string
	{
		return (string)$this->getData("query") ?? "";
	}

	/**
	 * Смещение результатов, которые нужно вернуть, может контролироваться ботом
	 * Offset of the results to be returned, can be controlled by the bot
	 *
	 * @return string
	 */
	public function getOffset(): string
	{
		return (string)$this->getData("offset") ?? "";
	}

	/**
	 * Опционально. Тип чата, из которого был отправлен инлайн-запрос.
	 * Может быть «sender» для личного чата с отправителем инлайн-запроса, «private», «group», «supergroup» или «channel».
	 * Тип чата всегда должен быть известен для запросов, отправленных из официальных клиентов и большинства сторонних клиентов,
	 * если запрос был отправлен из секретного чата
	 *
	 * Optional. Type of the chat from which the inline query was sent.
	 * Can be either “sender” for a private chat with the inline query sender, “private”, “group”, “supergroup”, or “channel”.
	 * The chat type should be always known for requests sent from official clients and most third-party clients,
	 * unless the request was sent from a secret chat
	 *
	 * @return InlineQueryChatEnum|null
	 */
	public function getChatType(): InlineQueryChatEnum|null
	{
		return InlineQueryChatEnum::tryFrom($this->getData("chat_type")) ?? null;
	}

	/**
	 * Опционально. Расположение отправителя, только для ботов, которые запрашивают местоположение пользователя
	 * Optional. Sender location, only for bots that request user location
	 *
	 * @return Location
	 */
	public function getLocation(): Location
	{
		return new Location($this->getData("location"));
	}

}
