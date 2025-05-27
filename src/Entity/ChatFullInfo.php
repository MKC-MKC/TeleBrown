<?php /** @noinspection PhpUnused */

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * ChatFullInfo – This object contains full information about a chat.
 * @see https://core.telegram.org/bots/api#chatfullinfo
 */
class ChatFullInfo extends ResponseWrapper
{

	public function getId(): int
	{
		return (int)$this->getData("id");
	}

	public function getType(): string
	{
		return (string)$this->getData("type");
	}

	public function getTitle(): string
	{
		return (string)$this->getData("title");
	}

	public function getUsername(): string
	{
		return (string)$this->getData("username");
	}

	public function getFirstName(): string
	{
		return (string)$this->getData("first_name");
	}

	public function getLastName(): string
	{
		return (string)$this->getData("last_name");
	}

	public function isForum(): bool
	{
		return (bool)$this->getData("is_forum");
	}

	public function getAccentColorId(): int
	{
		return (int)$this->getData("accent_color_id");
	}

	public function getMaxReactionCount(): int
	{
		return (int)$this->getData("max_reaction_count");
	}

	public function getPhoto(): ChatPhoto
	{
		$data = (array)$this->getData("photo", []);
		return new ChatPhoto($data);
	}

	public function getActiveUsernames(): array
	{
		return (array)$this->getData("active_usernames");
	}

	public function getBirthdate(): array
	{
		return (array)$this->getData("birthdate");
	}

	public function getBusinessIntro(): array
	{
		return (array)$this->getData("business_intro");
	}

	public function getBusinessLocation(): array
	{
		return (array)$this->getData("business_location");
	}

	public function getBusinessOpeningHours(): array
	{
		return (array)$this->getData("business_opening_hours");
	}

	public function getPersonalChat(): Chat
	{
		$data = (array)$this->getData("personal_chat", []);
		return new Chat($data);
	}

	public function getAvailableReactions(): array
	{
		return (array)$this->getData("available_reactions");
	}

	public function getBackgroundCustomEmojiId(): string
	{
		return (string)$this->getData("background_custom_emoji_id");
	}

	public function getProfileAccentColorId(): int
	{
		return (int)$this->getData("profile_accent_color_id");
	}

	public function getProfileBackgroundCustomEmojiId(): string
	{
		return (string)$this->getData("profile_background_custom_emoji_id");
	}

	public function getEmojiStatusCustomEmojiId(): string
	{
		return (string)$this->getData("emoji_status_custom_emoji_id");
	}

	public function getEmojiStatusExpirationDate(): int
	{
		return (int)$this->getData("emoji_status_expiration_date");
	}

	public function getBio(): string
	{
		return (string)$this->getData("bio");
	}

	public function hasPrivateForwards(): bool
	{
		return (bool)$this->getData("has_private_forwards");
	}

	public function hasRestrictedVoiceAndVideoMessages(): bool
	{
		return (bool)$this->getData("has_restricted_voice_and_video_messages");
	}

	public function joinToSendMessages(): bool
	{
		return (bool)$this->getData("join_to_send_messages");
	}

	public function joinByRequest(): bool
	{
		return (bool)$this->getData("join_by_request");
	}

	public function getDescription(): string
	{
		return (string)$this->getData("description");
	}

	public function getInviteLink(): string
	{
		return (string)$this->getData("invite_link");
	}

	public function getPinnedMessage(): Message
	{
		$data = (array)$this->getData("pinned_message", []);
		return new Message($data);
	}

	public function getPermissions(): ChatPermissions
	{
		$data = (array)$this->getData("permissions", []);
		return new ChatPermissions($data);
	}

	public function getAcceptedGiftTypes(): AcceptedGiftTypes
	{
		$data = (array)$this->getData("accepted_gift_types", []);
		return new AcceptedGiftTypes($data);
	}

	public function canSendPaidMedia(): bool
	{
		return (bool)$this->getData("can_send_paid_media");
	}

	public function getSlowModeDelay(): int
	{
		return (int)$this->getData("slow_mode_delay");
	}

	public function getUnrestrictBoostCount(): int
	{
		return (int)$this->getData("unrestrict_boost_count");
	}

	public function getMessageAutoDeleteTime(): int
	{
		return (int)$this->getData("message_auto_delete_time");
	}

	public function hasAggressiveAntiSpamEnabled(): bool
	{
		return (bool)$this->getData("has_aggressive_anti_spam_enabled");
	}

	public function hasHiddenMembers(): bool
	{
		return (bool)$this->getData("has_hidden_members");
	}

	public function hasProtectedContent(): bool
	{
		return (bool)$this->getData("has_protected_content");
	}

	public function hasVisibleHistory(): bool
	{
		return (bool)$this->getData("has_visible_history");
	}

	public function getStickerSetName(): string
	{
		return (string)$this->getData("sticker_set_name");
	}

	public function canSetStickerSet(): bool
	{
		return (bool)$this->getData("can_set_sticker_set");
	}

	public function getCustomEmojiStickerSetName(): string
	{
		return (string)$this->getData("custom_emoji_sticker_set_name");
	}

	public function getLinkedChatId(): int
	{
		return (int)$this->getData("linked_chat_id");
	}

	public function getLocation(): ChatLocation
	{
		$data = (array)$this->getData("location", []);
		return new ChatLocation($data);
	}

}
