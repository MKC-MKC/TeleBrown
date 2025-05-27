<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * CallbackQuery – This object represents an incoming callback query from a callback button in an inline keyboard.
 * If the button that originated the query was attached to a message sent by the bot, the field message will be present.
 * If the button was attached to a message sent via the bot (in inline mode), the field inline_message_id will be present.
 * Exactly one of the fields data or game_short_name will be present.
 * @see https://core.telegram.org/bots/api#callbackquery
 */
class CallbackQuery extends ResponseWrapper
{

	public function getId(): string
	{
		return (string)$this->getData("id") ?? "";
	}

	public function getFrom(): User
	{
		$data = (array)$this->getData("from", []);
		return new User($data);
	}

	/**
	 * Optional. Message sent by the bot with the callback button that originated the query
	 *
	 * @return MaybeInaccessibleMessage
	 */
	public function getMessage(): MaybeInaccessibleMessage
	{
		return MaybeInaccessibleMessage::getMessage($this->getAsArray());
	}

	public function getInlineMessageId(): string
	{
		return (string)$this->getData("inline_message_id");
	}

	public function getChatInstance(): string
	{
		return (string)$this->getData("chat_instance");
	}

	public function getCallbackData(): string
	{
		return (string)$this->getData("data");
	}

	public function getGameShortName(): string
	{
		return (string)$this->getData("game_short_name");
	}

}
