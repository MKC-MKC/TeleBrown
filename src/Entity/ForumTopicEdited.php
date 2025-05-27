<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * ForumTopicEdited – This object represents a service message about an edited forum topic.
 * @see https://core.telegram.org/bots/api#forumtopicedited
 */
class ForumTopicEdited extends ResponseWrapper
{

	public function getName(): string
	{
		return (string)$this->getData("name");
	}

	public function getIconCustomEmojiId(): ?string
	{
		return (string)$this->getData("icon_custom_emoji_id");
	}

}
