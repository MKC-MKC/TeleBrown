<?php /** @noinspection PhpUnused */

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * ChatFullInfo – This object contains full information about a chat.
 * @see https://core.telegram.org/bots/api#chatfullinfo
 */
class ChatFullInfo extends Type
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	public function getId(): int
	{
		return (int)$this->getData("id") ?? 0;
	}

	public function getType(): string
	{
		return (string)$this->getData("type") ?? "";
	}

	public function getTitle(): string
	{
		return (string)$this->getData("title") ?? "";
	}

	public function getUsername(): string
	{
		return (string)$this->getData("username") ?? "";
	}

	public function getFirstName(): string
	{
		return (string)$this->getData("first_name") ?? "";
	}

	public function getLastName(): string
	{
		return (string)$this->getData("last_name") ?? "";
	}

	public function isForum(): bool
	{
		return ($this->getData("is_forum") ?? false);
	}

	public function getAccentColorId(): int
	{
		return (int)$this->getData("accent_color_id") ?? 0;
	}

	public function getMaxReactionCount(): int
	{
		return (int)$this->getData("max_reaction_count") ?? 0;
	}

	public function getPhoto(): ChatPhoto
	{
		return new ChatPhoto($this->getData("photo"));
	}

	public function getActiveUsernames(): array
	{
		return $this->getData("active_usernames") ?? [];
	}

	public function getBirthdate(): array
	{
		return $this->getData("birthdate") ?? [];
	}

	public function getBusinessIntro(): array
	{
		return $this->getData("business_intro") ?? [];
	}

	public function getBusinessLocation(): array
	{
		return $this->getData("business_location") ?? [];
	}

	public function getBusinessOpeningHours(): array
	{
		return $this->getData("business_opening_hours") ?? [];
	}

	public function getPersonalChat(): Chat
	{
		return new Chat($this->getData("personal_chat"));
	}

	public function getAvailableReactions(): array
	{
		return $this->getData("available_reactions") ?? [];
	}

	public function getBackgroundCustomEmojiId(): string
	{
		return (string)$this->getData("background_custom_emoji_id") ?? "";
	}

	public function getProfileAccentColorId(): int
	{
		return (int)$this->getData("profile_accent_color_id") ?? 0;
	}

	public function getProfileBackgroundCustomEmojiId(): string
	{
		return (string)$this->getData("profile_background_custom_emoji_id") ?? "";
	}

	public function getEmojiStatusCustomEmojiId(): string
	{
		return (string)$this->getData("emoji_status_custom_emoji_id") ?? "";
	}

	public function getEmojiStatusExpirationDate(): int
	{
		return (int)$this->getData("emoji_status_expiration_date") ?? 0;
	}

	public function getBio(): string
	{
		return (string)$this->getData("bio") ?? "";
	}

	public function hasPrivateForwards(): bool
	{
		return ($this->getData("has_private_forwards") ?? false);
	}

	public function hasRestrictedVoiceAndVideoMessages(): bool
	{
		return ($this->getData("has_restricted_voice_and_video_messages") ?? false);
	}

	public function joinToSendMessages(): bool
	{
		return ($this->getData("join_to_send_messages") ?? false);
	}

	public function joinByRequest(): bool
	{
		return ($this->getData("join_by_request") ?? false);
	}

	public function getDescription(): string
	{
		return (string)$this->getData("description") ?? "";
	}

	public function getInviteLink(): string
	{
		return (string)$this->getData("invite_link") ?? "";
	}

	public function getPinnedMessage(): Message
	{
		return new Message($this->getData("pinned_message"));
	}

	public function getPermissions(): ChatPermissions
	{
		return new ChatPermissions($this->getData("permissions"));
	}

	public function getAcceptedGiftTypes(): AcceptedGiftTypes
	{
		return new AcceptedGiftTypes($this->getData("accepted_gift_types"));
	}

	public function canSendPaidMedia(): bool
	{
		return ($this->getData("can_send_paid_media") ?? false);
	}

	public function getSlowModeDelay(): int
	{
		return (int)$this->getData("slow_mode_delay") ?? 0;
	}

	public function getUnrestrictBoostCount(): int
	{
		return (int)$this->getData("unrestrict_boost_count") ?? 0;
	}

	public function getMessageAutoDeleteTime(): int
	{
		return (int)$this->getData("message_auto_delete_time") ?? 0;
	}

	public function hasAggressiveAntiSpamEnabled(): bool
	{
		return ($this->getData("has_aggressive_anti_spam_enabled") ?? false);
	}

	public function hasHiddenMembers(): bool
	{
		return ($this->getData("has_hidden_members") ?? false);
	}

	public function hasProtectedContent(): bool
	{
		return ($this->getData("has_protected_content") ?? false);
	}

	public function hasVisibleHistory(): bool
	{
		return ($this->getData("has_visible_history") ?? false);
	}

	public function getStickerSetName(): string
	{
		return (string)$this->getData("sticker_set_name") ?? "";
	}

	public function canSetStickerSet(): bool
	{
		return ($this->getData("can_set_sticker_set") ?? false);
	}

	public function getCustomEmojiStickerSetName(): string
	{
		return (string)$this->getData("custom_emoji_sticker_set_name") ?? "";
	}

	public function getLinkedChatId(): int
	{
		return (int)$this->getData("linked_chat_id") ?? 0;
	}

	public function getLocation(): ChatLocation
	{
		return new ChatLocation($this->getData("location"));
	}

}
