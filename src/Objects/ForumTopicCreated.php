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

	/**
	 * Проверяем, было ли название темы выбрано автоматически и требует ли оно изменения ботом.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#forumtopiccreated
	 */
	public function isNameImplicit(): bool
	{
		return (bool)$this->getData("is_name_implicit", false);
	}

}
