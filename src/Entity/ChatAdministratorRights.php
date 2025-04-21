<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * ChatAdministratorRights – Represents the rights of an administrator in a chat.
 * @see https://core.telegram.org/bots/api#chatadministratorrights
 */
class ChatAdministratorRights
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

	public function isAnonymous(): bool
	{
		return ($this->getAsArray()["is_anonymous"] ?? false);
	}

	public function canManageChat(): bool
	{
		return ($this->getAsArray()["can_manage_chat"] ?? false);
	}

	public function canDeleteMessages(): bool
	{
		return ($this->getAsArray()["can_delete_messages"] ?? false);
	}

	public function canManageVideoChats(): bool
	{
		return ($this->getAsArray()["can_manage_video_chats"] ?? false);
	}

	public function canRestrictMembers(): bool
	{
		return ($this->getAsArray()["can_restrict_members"] ?? false);
	}

	public function canPromoteMembers(): bool
	{
		return ($this->getAsArray()["can_promote_members"] ?? false);
	}

	public function canChangeInfo(): bool
	{
		return ($this->getAsArray()["can_change_info"] ?? false);
	}

	public function canInviteUsers(): bool
	{
		return ($this->getAsArray()["can_invite_users"] ?? false);
	}

	public function canPostStories(): bool
	{
		return ($this->getAsArray()["can_post_stories"] ?? false);
	}

	public function canEditStories(): bool
	{
		return ($this->getAsArray()["can_edit_stories"] ?? false);
	}

	public function canDeleteStories(): bool
	{
		return ($this->getAsArray()["can_delete_stories"] ?? false);
	}

	public function canPostMessages(): bool
	{
		return ($this->getAsArray()["can_post_messages"] ?? false);
	}

	public function canEditMessages(): bool
	{
		return ($this->getAsArray()["can_edit_messages"] ?? false);
	}

	public function canPinMessages(): bool
	{
		return ($this->getAsArray()["can_pin_messages"] ?? false);
	}

	public function canManageTopics(): bool
	{
		return ($this->getAsArray()["can_manage_topics"] ?? false);
	}

}
