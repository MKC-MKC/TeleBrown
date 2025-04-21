<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * ForumTopicCreated – This object represents a service message about a new forum topic created in the chat.
 * @see https://core.telegram.org/bots/api#forumtopiccreated
 */
class ForumTopicCreated
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

	public function getName(): string
	{
		return (string)$this->getAsArray()["name"] ?? "";
	}

	public function getIconColor(): int
	{
		return (int)$this->getAsArray()["icon_color"] ?? 0;
	}

	public function getIconCustomEmojiId(): ?string
	{
		return (string)$this->getAsArray()["icon_custom_emoji_id"] ?? null;
	}

}
