<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * ForumTopic – This object represents a forum topic.
 * @see https://core.telegram.org/bots/api#forumtopic
 */
class ForumTopic
{
	private array $response;

	public function __construct(array $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array
	{
		return $this->response ?? [];
	}

	/**
	 * Unique identifier of the forum topic
	 *
	 * @return int
	 */
	public function getMessageThreadId(): int
	{
		return (int)$this->getAsArray()["message_thread_id"] ?? 0;
	}

	/**
	 * Name of the topic
	 *
	 * @return string
	 */
	public function getName(): string
	{
		return (string)$this->getAsArray()["name"] ?? "";
	}

	/**
	 * Color of the topic icon in RGB format
	 *
	 * @return int
	 */
	public function getIconColor(): int
	{
		return (int)$this->getAsArray()["icon_color"] ?? 0;
	}

	/**
	 * Optional. Unique identifier of the custom emoji shown as the topic icon
	 *
	 * @return string
	 */
	public function getIconCustomEmojiId(): string
	{
		return (string)$this->getAsArray()["icon_custom_emoji_id"] ?? "";
	}

}
