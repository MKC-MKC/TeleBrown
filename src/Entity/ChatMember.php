<?php

namespace Haikiri\TeleBrown\Entity;

use RuntimeException;
use Haikiri\TeleBrown\ResponseWrapper;
use Haikiri\TeleBrown\Enums\ChatMemberEnum;

/**
 * ChatMember – This object contains information about one member of a chat.
 * @see https://core.telegram.org/bots/api#chatmember
 */
abstract class ChatMember extends ResponseWrapper
{

	public static function getChatMember(array $response): self
	{
		$source = $response["status"];
		return match ($response["status"]) {
			ChatMemberEnum::OWNER->value => new ChatMember\ChatMemberOwner($response),
			ChatMemberEnum::ADMINISTRATOR->value => new ChatMember\ChatMemberAdministrator($response),
			ChatMemberEnum::MEMBER->value => new ChatMember\ChatMemberMember($response),
			ChatMemberEnum::RESTRICTED->value => new ChatMember\ChatMemberRestricted($response),
			ChatMemberEnum::LEFT->value => new ChatMember\ChatMemberLeft($response),
			ChatMemberEnum::BANNED->value => new ChatMember\ChatMemberBanned($response),
			default => throw new RuntimeException("Unknown chat member status: `$source`"),
		};
	}

}
