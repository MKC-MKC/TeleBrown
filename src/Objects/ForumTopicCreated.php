<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * ForumTopicCreated – This object represents a service message about a new forum topic created in the chat.
 * @see https://core.telegram.org/bots/api#forumtopiccreated
 */
class ForumTopicCreated extends ResponseWrapper
{

	public function getName(): string
	{
		return (string)$this->getData("name");
	}

	public function getIconColor(): int
	{
		return (int)$this->getData("icon_color");
	}

	public function getIconCustomEmojiId(): string
	{
		return (string)$this->getData("icon_custom_emoji_id");
	}

}
