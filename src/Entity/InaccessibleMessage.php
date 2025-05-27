<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * InaccessibleMessage – This object describes a message that was deleted or is otherwise inaccessible to the bot.
 * @see https://core.telegram.org/bots/api#inaccessiblemessage
 */
class InaccessibleMessage extends MaybeInaccessibleMessage
{

	/**
	 * Chat the message belonged to
	 *
	 * @return Chat
	 */
	public function getChat(): Chat
	{
		$data = (array)$this->getData("chat", []);
		return new Chat($data);
	}

	/**
	 * Unique message identifier inside the chat
	 *
	 * @return int
	 */
	public function getId(): int
	{
		return (int)$this->getData("message_id");
	}

	/**
	 * Always 0. The field can be used to differentiate regular and inaccessible messages.
	 *
	 * @return int
	 */
	public function getDate(): int
	{
		return (int)$this->getData("date");
	}

}
