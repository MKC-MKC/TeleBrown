<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * ForumTopicCreated – This object represents a service message about a new forum topic created in the chat.
 * @see https://core.telegram.org/bots/api#forumtopiccreated
 */
class ForumTopicCreated extends Type
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	public function getName(): string
	{
		return (string)$this->getData("name") ?? "";
	}

	public function getIconColor(): int
	{
		return (int)$this->getData("icon_color") ?? 0;
	}

	public function getIconCustomEmojiId(): ?string
	{
		return (string)$this->getData("icon_custom_emoji_id") ?? null;
	}

}
