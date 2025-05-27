<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects\ChatMember;

use Haikiri\TeleBrown\Objects\User;
use Haikiri\TeleBrown\Objects\ChatMember;

/**
 * ChatMemberAdministrator – Represents a chat member that has some additional privileges.
 * @see https://core.telegram.org/bots/api#chatmemberadministrator
 */
class ChatMemberAdministrator extends ChatMember
{
	protected static string $status = "administrator";

	public static function getStatus(): string
	{
		return self::$status;
	}

	public function getUser(): User
	{
		$data = (array)$this->getData("user", []);
		return new User($data);
	}

	public function getCustomTitle(): string
	{
		return (string)$this->getData("custom_title");
	}

	public function isAnonymous(): bool
	{
		return (bool)$this->getData("is_anonymous");
	}

	public function canBeEdited(): bool
	{
		return (bool)$this->getData("can_be_edited");
	}

	public function canManageChat(): bool
	{
		return (bool)$this->getData("can_manage_chat");
	}

	public function canDeleteMessages(): bool
	{
		return (bool)$this->getData("can_delete_messages");
	}

	public function canManageVideoChats(): bool
	{
		return (bool)$this->getData("can_manage_video_chats");
	}

	public function canRestrictMembers(): bool
	{
		return (bool)$this->getData("can_restrict_members");
	}

	public function canPromoteMembers(): bool
	{
		return (bool)$this->getData("can_promote_members");
	}

	public function canChangeInfo(): bool
	{
		return (bool)$this->getData("can_change_info");
	}

	public function canInviteUsers(): bool
	{
		return (bool)$this->getData("can_invite_users");
	}

	public function canPostStories(): bool
	{
		return (bool)$this->getData("can_post_stories");
	}

	public function canEditStories(): bool
	{
		return (bool)$this->getData("can_edit_stories");
	}

	public function canDeleteStories(): bool
	{
		return (bool)$this->getData("can_delete_stories");
	}

	public function canPostMessages(): bool
	{
		return (bool)$this->getData("can_post_messages");
	}

	public function canEditMessages(): bool
	{
		return (bool)$this->getData("can_edit_messages");
	}

	public function canPinMessages(): bool
	{
		return (bool)$this->getData("can_pin_messages");
	}

	public function canManageTopics(): bool
	{
		return (bool)$this->getData("can_manage_topics");
	}

}
