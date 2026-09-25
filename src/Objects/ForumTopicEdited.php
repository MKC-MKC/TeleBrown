<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

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

	/**
	 * Получаем новый значок темы: null при отсутствии изменения, пустую строку при удалении.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#forumtopicedited
	 */
	public function getIconCustomEmojiId(): ?string
	{
		return $this->getData("icon_custom_emoji_id");
	}

}
