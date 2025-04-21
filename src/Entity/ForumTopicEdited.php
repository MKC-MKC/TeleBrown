<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * ForumTopicEdited – This object represents a service message about an edited forum topic.
 * @see https://core.telegram.org/bots/api#forumtopicedited
 */
class ForumTopicEdited
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

	public function getIconCustomEmojiId(): ?string
	{
		return (string)$this->getAsArray()["icon_custom_emoji_id"] ?? null;
	}

}
