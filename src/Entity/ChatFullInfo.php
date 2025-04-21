<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * ChatFullInfo – This object contains full information about a chat.
 * @see https://core.telegram.org/bots/api#chatfullinfo
 */
class ChatFullInfo
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

	public function getId(): int
	{
		return (int)$this->getAsArray()["id"] ?? 0;
	}

	public function getType(): string
	{
		return (string)$this->getAsArray()["type"] ?? "";
	}

	public function getTitle(): string
	{
		return (string)$this->getAsArray()["title"] ?? "";
	}

	public function getUsername(): string
	{
		return (string)$this->getAsArray()["username"] ?? "";
	}

	public function getFirstName(): string
	{
		return (string)$this->getAsArray()["first_name"] ?? "";
	}

	public function getLastName(): string
	{
		return (string)$this->getAsArray()["last_name"] ?? "";
	}

	public function isForum(): bool
	{
		return ($this->getAsArray()["is_forum"] ?? false);
	}

	public function getAccentColorId(): int
	{
		return (int)$this->getAsArray()["accent_color_id"] ?? 0;
	}

	public function getMaxReactionCount(): int
	{
		return (int)$this->getAsArray()["max_reaction_count"] ?? 0;
	}

	public function getPhoto(): ChatPhoto
	{
		return new ChatPhoto($this->getAsArray()["photo"] ?? []);
	}

	public function getActiveUsernames(): array
	{
		return $this->getAsArray()["active_usernames"] ?? [];
	}

	public function getBirthdate(): array
	{
		return $this->getAsArray()["birthdate"] ?? [];
	}

	public function getBusinessIntro(): array
	{
		return $this->getAsArray()["business_intro"] ?? [];
	}

	public function getBusinessLocation(): array
	{
		return $this->getAsArray()["business_location"] ?? [];
	}

	public function getBusinessOpeningHours(): array
	{
		return $this->getAsArray()["business_opening_hours"] ?? [];
	}

	public function getPersonalChat(): Chat
	{
		return new Chat($this->getAsArray()["personal_chat"] ?? []);
	}

	public function getAvailableReactions(): array
	{
		return $this->getAsArray()["available_reactions"] ?? [];
	}

	public function getBackgroundCustomEmojiId(): string
	{
		return (string)$this->getAsArray()["background_custom_emoji_id"] ?? "";
	}

	public function getProfileAccentColorId(): int
	{
		return (int)$this->getAsArray()["profile_accent_color_id"] ?? 0;
	}

	public function getProfileBackgroundCustomEmojiId(): string
	{
		return (string)$this->getAsArray()["profile_background_custom_emoji_id"] ?? "";
	}

	public function getEmojiStatusCustomEmojiId(): string
	{
		return (string)$this->getAsArray()["emoji_status_custom_emoji_id"] ?? "";
	}

	public function getEmojiStatusExpirationDate(): int
	{
		return (int)$this->getAsArray()["emoji_status_expiration_date"] ?? 0;
	}

	public function getBio(): string
	{
		return (string)$this->getAsArray()["bio"] ?? "";
	}

	public function hasPrivateForwards(): bool
	{
		return ($this->getAsArray()["has_private_forwards"] ?? false);
	}

	public function hasRestrictedVoiceAndVideoMessages(): bool
	{
		return ($this->getAsArray()["has_restricted_voice_and_video_messages"] ?? false);
	}

	public function joinToSendMessages(): bool
	{
		return ($this->getAsArray()["join_to_send_messages"] ?? false);
	}

	public function joinByRequest(): bool
	{
		return ($this->getAsArray()["join_by_request"] ?? false);
	}

	public function getDescription(): string
	{
		return (string)$this->getAsArray()["description"] ?? "";
	}

	public function getInviteLink(): string
	{
		return (string)$this->getAsArray()["invite_link"] ?? "";
	}

	public function getPinnedMessage(): Message
	{
		return new Message($this->getAsArray()["pinned_message"] ?? []);
	}

	public function getPermissions(): ChatPermissions
	{
		return new ChatPermissions($this->getAsArray()["permissions"] ?? []);
	}

	public function getAcceptedGiftTypes(): AcceptedGiftTypes
	{
		return new AcceptedGiftTypes($this->getAsArray()["accepted_gift_types"] ?? []);
	}

	public function canSendPaidMedia(): bool
	{
		return ($this->getAsArray()["can_send_paid_media"] ?? false);
	}

	public function getSlowModeDelay(): int
	{
		return (int)$this->getAsArray()["slow_mode_delay"] ?? 0;
	}

	public function getUnrestrictBoostCount(): int
	{
		return (int)$this->getAsArray()["unrestrict_boost_count"] ?? 0;
	}

	public function getMessageAutoDeleteTime(): int
	{
		return (int)$this->getAsArray()["message_auto_delete_time"] ?? 0;
	}

	public function hasAggressiveAntiSpamEnabled(): bool
	{
		return ($this->getAsArray()["has_aggressive_anti_spam_enabled"] ?? false);
	}

	public function hasHiddenMembers(): bool
	{
		return ($this->getAsArray()["has_hidden_members"] ?? false);
	}

	public function hasProtectedContent(): bool
	{
		return ($this->getAsArray()["has_protected_content"] ?? false);
	}

	public function hasVisibleHistory(): bool
	{
		return ($this->getAsArray()["has_visible_history"] ?? false);
	}

	public function getStickerSetName(): string
	{
		return (string)$this->getAsArray()["sticker_set_name"] ?? "";
	}

	public function canSetStickerSet(): bool
	{
		return ($this->getAsArray()["can_set_sticker_set"] ?? false);
	}

	public function getCustomEmojiStickerSetName(): string
	{
		return (string)$this->getAsArray()["custom_emoji_sticker_set_name"] ?? "";
	}

	public function getLinkedChatId(): int
	{
		return (int)$this->getAsArray()["linked_chat_id"] ?? 0;
	}

	public function getLocation(): ChatLocation
	{
		return new ChatLocation($this->getAsArray()["location"] ?? []);
	}

}
