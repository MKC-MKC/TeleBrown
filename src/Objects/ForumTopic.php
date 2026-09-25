<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * ForumTopic – This object represents a forum topic.
 * @see https://core.telegram.org/bots/api#forumtopic
 */
class ForumTopic extends ResponseWrapper
{

	/**
	 * Unique identifier of the forum topic
	 *
	 * @return int
	 */
	public function getMessageThreadId(): int
	{
		return (int)$this->getData("message_thread_id");
	}

	/**
	 * Name of the topic
	 *
	 * @return string
	 */
	public function getName(): string
	{
		return (string)$this->getData("name");
	}

	/**
	 * Color of the topic icon in RGB format
	 *
	 * @return int
	 */
	public function getIconColor(): int
	{
		return (int)$this->getData("icon_color");
	}

	/**
	 * Optional. Unique identifier of the custom emoji shown as the topic icon
	 *
	 * @return string
	 */
	public function getIconCustomEmojiId(): string
	{
		return (string)$this->getData("icon_custom_emoji_id");
	}

	/**
	 * Проверяем, было ли название темы выбрано автоматически и требует ли оно изменения ботом.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#forumtopic
	 */
	public function isNameImplicit(): bool
	{
		return (bool)$this->getData("is_name_implicit", false);
	}

}
