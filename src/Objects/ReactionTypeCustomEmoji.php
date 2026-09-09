<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

class ReactionTypeCustomEmoji extends ReactionType
{

	public function __construct(string $customEmojiId)
	{
		parent::__construct([
			"type" => "custom_emoji",
			"custom_emoji_id" => $customEmojiId,
		]);
	}

}
