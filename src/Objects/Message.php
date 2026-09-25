<?php /** @noinspection PhpUnused */

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use DateTime;
use Exception;
use Haikiri\TeleBrown\Enums\MessageTypesEnum;

/**
 * Message – This object represents a message.
 * @see https://core.telegram.org/bots/api#message
 */
class Message extends MaybeInaccessibleMessage
{

	/**
	 * Метод возвращает тип сообщения.
	 *
	 * @return MessageTypesEnum|null
	 */
	public function getType(): ?MessageTypesEnum
	{
		return match (true) {
			$this->getData("text") !== null => MessageTypesEnum::TEXT,
			$this->getData("audio") !== null => MessageTypesEnum::AUDIO,
			$this->getData("animation") !== null => MessageTypesEnum::ANIMATION,
			$this->getData("document") !== null => MessageTypesEnum::DOCUMENT,
			$this->getData("game") !== null => MessageTypesEnum::GAME,
			$this->getData("live_photo") !== null => MessageTypesEnum::LIVE_PHOTO,
			$this->getData("photo") !== null => MessageTypesEnum::PHOTO,
			$this->getData("sticker") !== null => MessageTypesEnum::STICKER,
			$this->getData("video") !== null => MessageTypesEnum::VIDEO,
			$this->getData("voice") !== null => MessageTypesEnum::VOICE,
			$this->getData("video_note") !== null => MessageTypesEnum::VIDEO_NOTE,
			$this->getData("contact") !== null => MessageTypesEnum::CONTACT,
			$this->getData("venue") !== null => MessageTypesEnum::VENUE,
			$this->getData("location") !== null => MessageTypesEnum::LOCATION,
			$this->getData("poll") !== null => MessageTypesEnum::POLL,
			$this->getData("dice") !== null => MessageTypesEnum::DICE,
			$this->getData("new_chat_members") !== null => MessageTypesEnum::NEW_CHAT_MEMBERS,
			$this->getData("left_chat_member") !== null => MessageTypesEnum::LEFT_CHAT_MEMBER,
			$this->getData("new_chat_title") !== null => MessageTypesEnum::NEW_CHAT_TITLE,
			$this->getData("new_chat_photo") !== null => MessageTypesEnum::NEW_CHAT_PHOTO,
			$this->getData("message_auto_delete_timer_changed") !== null => MessageTypesEnum::AUTO_DELETE_TIMER_CHANGED,
			$this->getData("pinned_message") !== null => MessageTypesEnum::PINNED_MESSAGE,
			$this->getData("invoice") !== null => MessageTypesEnum::INVOICE,
			$this->getData("successful_payment") !== null => MessageTypesEnum::SUCCESSFUL_PAYMENT,
			$this->getData("users_shared") !== null => MessageTypesEnum::USERS_SHARED,
			$this->getData("chat_shared") !== null => MessageTypesEnum::CHAT_SHARED,
			$this->getData("connected_website") !== null => MessageTypesEnum::CONNECTED_WEBSITE,
			$this->getData("write_access_allowed") !== null => MessageTypesEnum::WRITE_ACCESS_ALLOWED,
			$this->getData("passport_data") !== null => MessageTypesEnum::PASSPORT_DATA,
			$this->getData("proximity_alert_triggered") !== null => MessageTypesEnum::PROXIMITY_ALERT_TRIGGERED,
			$this->getData("forum_topic_created") !== null => MessageTypesEnum::FORUM_TOPIC_CREATED,
			$this->getData("forum_topic_edited") !== null => MessageTypesEnum::FORUM_TOPIC_EDITED,
			$this->getData("forum_topic_closed") !== null => MessageTypesEnum::FORUM_TOPIC_CLOSED,
			$this->getData("forum_topic_reopened") !== null => MessageTypesEnum::FORUM_TOPIC_REOPENED,
			$this->getData("general_forum_topic_hidden") !== null => MessageTypesEnum::GENERAL_FORUM_TOPIC_HIDDEN,
			$this->getData("general_forum_topic_unhidden") !== null => MessageTypesEnum::GENERAL_FORUM_TOPIC_UNHIDDEN,
			$this->getData("giveaway") !== null => MessageTypesEnum::GIVEAWAY,
			$this->getData("giveaway_winners") !== null => MessageTypesEnum::GIVEAWAY_WINNERS,
			$this->getData("video_chat_scheduled") !== null => MessageTypesEnum::VIDEO_CHAT_SCHEDULED,
			$this->getData("video_chat_started") !== null => MessageTypesEnum::VIDEO_CHAT_STARTED,
			$this->getData("video_chat_ended") !== null => MessageTypesEnum::VIDEO_CHAT_ENDED,
			$this->getData("video_chat_participants_invited") !== null => MessageTypesEnum::VIDEO_CHAT_PARTICIPANTS_INVITED,
			$this->getData("rich_message") !== null => MessageTypesEnum::RICH_MESSAGE,
			$this->getData("checklist") !== null => MessageTypesEnum::CHECKLIST,
			$this->getData("paid_media") !== null => MessageTypesEnum::PAID_MEDIA,
			$this->getData("story") !== null => MessageTypesEnum::STORY,
			$this->getData("delete_chat_photo") !== null => MessageTypesEnum::DELETE_CHAT_PHOTO,
			$this->getData("group_chat_created") !== null => MessageTypesEnum::GROUP_CHAT_CREATED,
			$this->getData("supergroup_chat_created") !== null => MessageTypesEnum::SUPERGROUP_CHAT_CREATED,
			$this->getData("channel_chat_created") !== null => MessageTypesEnum::CHANNEL_CHAT_CREATED,
			$this->getData("migrate_to_chat_id") !== null => MessageTypesEnum::MIGRATE_TO_CHAT_ID,
			$this->getData("migrate_from_chat_id") !== null => MessageTypesEnum::MIGRATE_FROM_CHAT_ID,
			$this->getData("refunded_payment") !== null => MessageTypesEnum::REFUNDED_PAYMENT,
			$this->getData("gift") !== null => MessageTypesEnum::GIFT,
			$this->getData("unique_gift") !== null => MessageTypesEnum::UNIQUE_GIFT,
			$this->getData("gift_upgrade_sent") !== null => MessageTypesEnum::GIFT_UPGRADE_SENT,
			$this->getData("chat_owner_left") !== null => MessageTypesEnum::CHAT_OWNER_LEFT,
			$this->getData("chat_owner_changed") !== null => MessageTypesEnum::CHAT_OWNER_CHANGED,
			$this->getData("checklist_tasks_done") !== null => MessageTypesEnum::CHECKLIST_TASKS_DONE,
			$this->getData("checklist_tasks_added") !== null => MessageTypesEnum::CHECKLIST_TASKS_ADDED,
			$this->getData("community_chat_added") !== null => MessageTypesEnum::COMMUNITY_CHAT_ADDED,
			$this->getData("community_chat_joined") !== null => MessageTypesEnum::COMMUNITY_CHAT_JOINED,
			$this->getData("community_chat_removed") !== null => MessageTypesEnum::COMMUNITY_CHAT_REMOVED,
			$this->getData("direct_message_price_changed") !== null => MessageTypesEnum::DIRECT_MESSAGE_PRICE_CHANGED,
			$this->getData("managed_bot_created") !== null => MessageTypesEnum::MANAGED_BOT_CREATED,
			$this->getData("poll_option_added") !== null => MessageTypesEnum::POLL_OPTION_ADDED,
			$this->getData("poll_option_deleted") !== null => MessageTypesEnum::POLL_OPTION_DELETED,
			$this->getData("suggested_post_approved") !== null => MessageTypesEnum::SUGGESTED_POST_APPROVED,
			$this->getData("suggested_post_approval_failed") !== null => MessageTypesEnum::SUGGESTED_POST_APPROVAL_FAILED,
			$this->getData("suggested_post_declined") !== null => MessageTypesEnum::SUGGESTED_POST_DECLINED,
			$this->getData("suggested_post_paid") !== null => MessageTypesEnum::SUGGESTED_POST_PAID,
			$this->getData("suggested_post_refunded") !== null => MessageTypesEnum::SUGGESTED_POST_REFUNDED,
			$this->getData("boost_added") !== null => MessageTypesEnum::BOOST_ADDED,
			$this->getData("chat_background_set") !== null => MessageTypesEnum::CHAT_BACKGROUND_SET,
			$this->getData("giveaway_created") !== null => MessageTypesEnum::GIVEAWAY_CREATED,
			$this->getData("giveaway_completed") !== null => MessageTypesEnum::GIVEAWAY_COMPLETED,
			$this->getData("web_app_data") !== null => MessageTypesEnum::WEB_APP_DATA,
			default => null
		};
	}

	/**
	 * Unique message identifier inside this chat.
	 * In specific instances (e.g., message containing a video sent to a big chat),
	 * the server might automatically schedule a message instead of sending it immediately.
	 * In such cases, this field will be 0 and the relevant message will be unusable until it is actually sent
	 *
	 * @return int
	 */
	public function getId(): int
	{
		return (int)$this->getData("message_id");
	}

	/**
	 * Optional. Unique identifier of a message thread to which the message belongs; for supergroups only
	 *
	 * @return int
	 */
	public function getThreadId(): int
	{
		return (int)$this->getData("message_thread_id");
	}

	/**
	 * Type of the chat, can be either “private”, “group”, “supergroup” or “channel”
	 *
	 * @return User
	 */
	public function getFrom(): User
	{
		$data = (array)$this->getData("from", []);
		return new User($data);
	}

	/**
	 * Optional. Sender of the message when sent on behalf of a chat.
	 * For example, the supergroup itself for messages sent by its anonymous administrators or a linked channel
	 * for messages automatically forwarded to the channel's discussion group.
	 * For backward compatibility, if the message was sent on behalf of a chat,
	 * the field from contains a fake sender user in non-channel chats.
	 *
	 * @return Chat
	 */
	public function getSenderChat(): Chat
	{
		$data = (array)$this->getData("sender_chat", []);
		return new Chat($data);
	}

	/**
	 * Optional. If the sender of the message boosted the chat, the number of boosts added by the user
	 *
	 * @return int
	 */
	public function getSenderBoostCount(): int
	{
		return (int)$this->getData("sender_boost_count");
	}

	/**
	 * Optional. The bot that actually sent the message on behalf of the business account.
	 * Available only for outgoing messages sent on behalf of the connected business account.
	 *
	 * @return User
	 */
	public function getSenderBusinessBot(): User
	{
		$data = (array)$this->getData("sender_business_bot", []);
		return new User($data);
	}

	/**
	 * Date the message was sent in Unix time.
	 * It is always a positive number, representing a valid date.
	 *
	 * @return int
	 */
	public function getDate(): int
	{
		return (int)$this->getData("date") ?? 0;
	}

	/**
	 * Returns the date as a DateTime object.
	 *
	 * @return DateTime|null
	 */
	public function getDateTime(): DateTime|null
	{
		try {
			return new DateTime("@{$this->getData("date", 0)}");
		} catch (Exception) {
			return null;
		}
	}

	/**
	 * Optional. Unique identifier of the business connection from which the message was received.
	 * If non-empty, the message belongs to a chat of the corresponding business account that is independent,
	 * from any potential bot chat which might share the same identifier.
	 *
	 * @return string
	 */
	public function getBusinessConnectionId(): string
	{
		return (string)$this->getData("business_connection_id");
	}

	/**
	 * Chat the message belongs to
	 *
	 * @return Chat
	 */
	public function getChat(): Chat
	{
		$data = (array)$this->getData("chat", []);
		return new Chat($data);
	}

	/**
	 * Optional. Information about the original message for forwarded messages
	 *
	 * @return array
	 */
	public function getForwardOrigin(): array
	{
		return (array)$this->getData("forward_origin");
	}

	/**
	 * Optional. True, if the message is sent to a forum topic
	 *
	 * @return bool
	 */
	public function isTopicMessage(): bool
	{
		return (bool)$this->getData("is_topic_message");
	}

	/**
	 * Optional. True, if the message is a channel post that was automatically forwarded to the connected discussion group
	 *
	 * @return bool
	 */
	public function isAutomaticForward(): bool
	{
		return (bool)$this->getData("is_automatic_forward");
	}

	/**
	 * Optional. For replies in the same chat and message thread, the original message.
	 * Note that the Message object in this field will not contain further reply_to_message fields even if it itself is a reply.
	 *
	 * @return Message
	 */
	public function getReplyToMessage(): Message
	{
		$data = (array)$this->getData("reply_to_message", []);
		return new Message($data);
	}

	/**
	 * Optional. Information about the message that is being replied to, which may come from another chat or forum topic
	 *
	 * @return array
	 */
	public function getExternalReply(): array
	{
		return (array)$this->getData("external_reply");
	}

	/**
	 * Optional. For replies that quote part of the original message, the quoted part of the message
	 *
	 * @return array
	 */
	public function getQuote(): array
	{
		return (array)$this->getData("quote");
	}

	/**
	 * Optional. For replies to a story, the original story
	 *
	 * @return array
	 */
	public function getReplyToStory(): array
	{
		return (array)$this->getData("reply_to_story");
	}

	/**
	 * Optional. Bot through which the message was sent
	 *
	 * @return User
	 */
	public function getViaBot(): User
	{
		$data = (array)$this->getData("via_bot", []);
		return new User($data);
	}

	/**
	 * Optional. Date the message was last edited in Unix time
	 *
	 * @return DateTime|null
	 */
	public function getEditDateTime(): DateTime|null
	{
		try {
			return new DateTime("@{$this->getData("edit_date", 0)}");
		} catch (Exception) {
			return null;
		}
	}

	/**
	 * Optional. True, if the message can't be forwarded
	 */
	public function hasProtectedContent(): bool
	{
		return (bool)$this->getData("has_protected_content");
	}

	/**
	 * Optional. True, if the message was sent by an implicit action,
	 * for example, as an away or a greeting business message, or as a scheduled message
	 *
	 * @return bool
	 */
	public function isFromOffline(): bool
	{
		return (bool)$this->getData("is_from_offline");
	}

	/**
	 * Optional. The unique identifier of a media message group this message belongs to
	 *
	 * @return string
	 */
	public function getMediaGroupId(): string
	{
		return (string)$this->getData("media_group_id");
	}

	/**
	 * Optional. Signature of the post author for messages in channels, or the custom title of an anonymous group administrator
	 *
	 * @return string
	 */
	public function getAuthorSignature(): string
	{
		return (string)$this->getData("author_signature");
	}

	/**
	 * Optional. The number of Telegram Stars that were paid by the sender of the message to send it
	 *
	 * @return int
	 */
	public function getPaidStarCount(): int
	{
		return (int)$this->getData("paid_star_count");
	}

	/**
	 * Optional. For text messages, the actual UTF-8 text of the message
	 *
	 * @return string
	 */
	public function getText(): string
	{
		return (string)$this->getData("text");
	}

	/**
	 * Optional. For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text
	 *
	 * @return array
	 */
	public function getEntities(): array
	{
		return (array)$this->getData("entities");
	}

	/**
	 * Optional. Options used for link preview generation for the message, if it is a text message and link preview options were changed
	 *
	 * @return array
	 */
	public function getLinkPreviewOptions(): array
	{
		return (array)$this->getData("link_preview_options");
	}

	/**
	 * Optional. Unique identifier of the message effect added to the message
	 *
	 * @return string
	 */
	public function getEffectId(): string
	{
		return (string)$this->getData("effect_id");
	}

	/**
	 * Optional. Message is an animation, information about the animation.
	 * For backward compatibility, when this field is set, the document field will also be set
	 *
	 * @return array
	 */
	public function getAnimation(): array
	{
		return (array)$this->getData("animation");
	}

	/**
	 * Optional. Message is an audio file, information about the file
	 *
	 * @return array
	 */
	public function getAudio(): array
	{
		return (array)$this->getData("audio");
	}

	/**
	 * Optional. Message is a general file, information about the file
	 *
	 * @return array
	 */
	public function getDocument(): array
	{
		return (array)$this->getData("document");
	}

	/**
	 * Optional. Message contains paid media; information about the paid media
	 *
	 * @return array
	 */
	public function getPaidMedia(): array
	{
		return (array)$this->getData("paid_media");
	}

	/**
	 * Optional. Message is a photo, available sizes of the photo
	 *
	 * @return array
	 */
	public function getPhoto(): array
	{
		return (array)$this->getData("photo");
	}

	/**
	 * Optional. Message is a sticker, information about the sticker
	 *
	 * @return array
	 */
	public function getSticker(): array
	{
		return (array)$this->getData("sticker");
	}

	/**
	 * Optional. Message is a forwarded story
	 *
	 * @return array
	 */
	public function getStory(): array
	{
		return (array)$this->getData("story");
	}

	/**
	 * Optional. Message is a video, information about the video
	 *
	 * @return array
	 */
	public function getVideo(): array
	{
		return (array)$this->getData("video");
	}

	/**
	 * Optional. Message is a video note, information about the video message
	 *
	 * @return array
	 */
	public function getVideoNote(): array
	{
		return (array)$this->getData("video_note");
	}

	/**
	 * Optional. Message is a voice message, information about the file
	 *
	 * @return array
	 */
	public function getVoice(): array
	{
		return (array)$this->getData("voice");
	}

	/**
	 * Optional. Caption for the animation, audio, document, paid media, photo, video or voice
	 *
	 * @return string
	 */
	public function getCaption(): string
	{
		return (string)$this->getData("caption");
	}

	/**
	 * Optional. For messages with a caption, special entities like usernames, URLs, bot commands, etc. that appear in the caption
	 *
	 * @return array
	 */
	public function getCaptionEntities(): array
	{
		return (array)$this->getData("caption_entities");
	}

	/**
	 * Optional. True, if the caption must be shown above the message media
	 *
	 * @return bool
	 */
	public function showCaptionAboveMedia(): bool
	{
		return (bool)$this->getData("show_caption_above_media");
	}

	/**
	 * Optional. True, if the message media is covered by a spoiler animation
	 *
	 * @return bool
	 */
	public function hasMediaSpoiler(): bool
	{
		return (bool)$this->getData("has_media_spoiler");
	}

	/**
	 * Optional. Message is a shared contact, information about the contact
	 *
	 * @return Contact
	 */
	public function getContact(): Contact
	{
		$data = (array)$this->getData("contact", []);
		return new Contact($data);
	}

	/**
	 * Optional. Message is a 'dice' with random value
	 *
	 * @return array
	 */
	public function getDice(): array
	{
		return (array)$this->getData("dice");
	}

	/**
	 * Optional. Message is a game, information about the game. More about games »
	 *
	 * @return array
	 */
	public function getGame(): array
	{
		return (array)$this->getData("game");
	}

	/**
	 * Optional. Message is a native poll, information about the poll
	 *
	 * @return array
	 */
	public function getPoll(): array
	{
		return (array)$this->getData("poll");
	}

	/**
	 * Optional. Message is a venue, information about the venue.
	 * For backward compatibility, when this field is set, the location field will also be set
	 *
	 * @return array
	 */
	public function getVenue(): array
	{
		return (array)$this->getData("venue");
	}

	/**
	 * Optional. Message is a shared location, information about the location
	 *
	 * @return array
	 */
	public function getLocation(): array
	{
		return (array)$this->getData("location");
	}

	/**
	 * Optional. New members that were added to the group or supergroup and information about them (the bot itself may be one of these members)
	 *
	 * @return array of User
	 */
	public function getNewChatMembers(): array
	{
		return (array)$this->getData("new_chat_members");
	}

	/**
	 * Optional. A member was removed from the group, information about them (this member may be the bot itself)
	 *
	 * @return User
	 */
	public function getLeftChatMember(): User
	{
		$data = (array)$this->getData("left_chat_member", []);
		return new User($data);
	}

	/**
	 * Optional. A chat title was changed to this value
	 *
	 * @return string
	 */
	public function getNewChatTitle(): string
	{
		return (string)$this->getData("new_chat_title");
	}

	/**
	 * Optional. A chat photo was change to this value
	 *
	 * @return array of PhotoSize
	 */
	public function getNewChatPhoto(): array
	{
		return (array)$this->getData("new_chat_photo");
	}

	/**
	 * Optional. Service message: the chat photo was deleted
	 *
	 * @return bool
	 */
	public function deleteChatPhoto(): bool
	{
		return (bool)$this->getData("delete_chat_photo");
	}

	/**
	 * Optional. Service message: the group has been created
	 *
	 * @return bool
	 */
	public function isGroupChatCreated(): bool
	{
		return (bool)$this->getData("group_chat_created");
	}

	/**
	 * Optional. Service message: the supergroup has been created.
	 * This field can't be received in a message coming through updates, because bot can't be a member of a supergroup when it is created.
	 * It can only be found in reply_to_message if someone replies to a very first message in a directly created supergroup.
	 *
	 * @return bool
	 */
	public function isSupergroupChatCreated(): bool
	{
		return (bool)$this->getData("supergroup_chat_created");
	}

	/**
	 * Optional. Service message: the channel has been created.
	 * This field can't be received in a message coming through updates, because bot can't be a member of a channel when it is created.
	 * It can only be found in reply_to_message if someone replies to a very first message in a channel.
	 *
	 * @return bool
	 */
	public function isChannelChatCreated(): bool
	{
		return (bool)$this->getData("channel_chat_created");
	}

	/**
	 * Optional. Service message: auto-delete timer settings changed in the chat
	 *
	 * @return array
	 */
	public function getMessageAutoDeleteTimerChanged(): array
	{
		return (array)$this->getData("message_auto_delete_timer_changed");
	}

	/**
	 * Optional. The group has been migrated to a supergroup with the specified identifier.
	 * This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it.
	 * But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this identifier.
	 *
	 * @return int
	 */
	public function getMigrateToChatId(): int
	{
		return (int)$this->getData("migrate_to_chat_id");
	}

	/**
	 * Optional. The supergroup has been migrated from a group with the specified identifier.
	 * This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it.
	 * But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this identifier.
	 *
	 * @return int
	 */
	public function getMigrateFromChatId(): int
	{
		return (int)$this->getData("migrate_from_chat_id");
	}

	/**
	 * Optional. Specified message was pinned.
	 * Note that the Message object in this field will not contain further reply_to_message fields even if it itself is a reply.
	 *
	 * @return array
	 */
	public function getPinnedMessage(): array
	{
		return (array)$this->getData("pinned_message");
	}

	/**
	 * Optional. Message is an invoice for a payment, information about the invoice. More about payments »
	 *
	 * @return array
	 */
	public function getInvoice(): array
	{
		return (array)$this->getData("invoice");
	}

	/**
	 * Optional. Message is a service message about a successful payment, information about the payment. More about payments »
	 *
	 * @return array
	 */
	public function getSuccessfulPayment(): array
	{
		return (array)$this->getData("successful_payment");
	}

	/**
	 * Optional. Message is a service message about a refunded payment, information about the payment. More about payments »
	 *
	 * @return array
	 */
	public function getRefundedPayment(): array
	{
		return (array)$this->getData("refunded_payment");
	}

	/**
	 * Optional. Service message: users were shared with the bot
	 *
	 * @return array
	 */
	public function getUsersShared(): array
	{
		return (array)$this->getData("users_shared");
	}

	/**
	 * Optional. Service message: a chat was shared with the bot
	 *
	 * @return array
	 */
	public function getChatShared(): array
	{
		return (array)$this->getData("chat_shared");
	}

	/**
	 * Optional. Service message: a regular gift was sent or received
	 *
	 * @return array
	 */
	public function getGift(): array
	{
		return (array)$this->getData("gift");
	}

	/**
	 * Optional. Service message: a unique gift was sent or received
	 *
	 * @return array
	 */
	public function getUniqueGift(): array
	{
		return (array)$this->getData("unique_gift");
	}

	/**
	 * Optional. The domain name of the website on which the user has logged in. More about Telegram Login »
	 *
	 * @return string
	 */
	public function getConnectedWebsite(): string
	{
		return (string)$this->getData("connected_website");
	}

	/**
	 * Optional. Service message: the user allowed the bot to write messages after adding it to the attachment or side menu,
	 * launching a Web App from a link, or accepting an explicit request from a Web App sent by the method requestWriteAccess
	 *
	 * @return array
	 */
	public function getWriteAccessAllowed(): array
	{
		return (array)$this->getData("write_access_allowed");
	}

	/**
	 * Optional. Telegram Passport data
	 *
	 * @return array
	 */
	public function getPassportData(): array
	{
		return (array)$this->getData("passport_data");
	}

	/**
	 * Optional. Service message. A user in the chat triggered another user's proximity alert while sharing Live Location.
	 *
	 * @return array
	 */
	public function getProximityAlertTriggered(): array
	{
		return (array)$this->getData("proximity_alert_triggered");
	}

	/**
	 * Optional. Service message: user boosted the chat
	 *
	 * @return array
	 */
	public function getBoostAdded(): array
	{
		return (array)$this->getData("boost_added");
	}

	/**
	 * Optional. Service message: chat background set
	 *
	 * @return array
	 */
	public function getChatBackgroundSet(): array
	{
		return (array)$this->getData("chat_background_set");
	}

	/**
	 * Optional. Service message: forum topic created
	 *
	 * @return array
	 */
	public function getForumTopicCreated(): array
	{
		return (array)$this->getData("forum_topic_created");
	}

	/**
	 * Optional. Service message: forum topic edited
	 *
	 * @return array
	 */
	public function getForumTopicEdited(): array
	{
		return (array)$this->getData("forum_topic_edited");
	}

	/**
	 * Optional. Service message: forum topic closed
	 *
	 * @return array
	 */
	public function getForumTopicClosed(): array
	{
		return (array)$this->getData("forum_topic_closed");
	}

	/**
	 * Optional. Service message: forum topic reopened
	 *
	 * @return array
	 */
	public function getForumTopicReopened(): array
	{
		return (array)$this->getData("forum_topic_reopened");
	}

	/**
	 * Optional. Service message: the 'General' forum topic hidden
	 *
	 * @return array
	 */
	public function getGeneralForumTopicHidden(): array
	{
		return (array)$this->getData("general_forum_topic_hidden");
	}

	/**
	 * Optional. Service message: the 'General' forum topic unhidden
	 *
	 * @return array
	 */
	public function getGeneralForumTopicUnhidden(): array
	{
		return (array)$this->getData("general_forum_topic_unhidden");
	}

	/**
	 * Optional. Service message: a scheduled giveaway was created
	 *
	 * @return array
	 */
	public function getGiveawayCreated(): array
	{
		return (array)$this->getData("giveaway_created");
	}

	/**
	 * Optional. The message is a scheduled giveaway message
	 *
	 * @return array
	 */
	public function getGiveaway(): array
	{
		return (array)$this->getData("giveaway");
	}

	/**
	 * Optional. A giveaway with public winners was completed
	 *
	 * @return array
	 */
	public function getGiveawayWinners(): array
	{
		return (array)$this->getData("giveaway_winners");
	}

	/**
	 * Optional. Service message: a giveaway without public winners was completed
	 *
	 * @return array
	 */
	public function getGiveawayCompleted(): array
	{
		return (array)$this->getData("giveaway_completed");
	}

	/**
	 * Optional. Service message: the price for paid messages has changed in the chat
	 *
	 * @return array
	 */
	public function getPaidMessagePriceChanged(): array
	{
		return (array)$this->getData("paid_message_price_changed");
	}

	/**
	 * Optional. Service message: video chat scheduled
	 *
	 * @return array
	 */
	public function getVideoChatScheduled(): array
	{
		return (array)$this->getData("video_chat_scheduled");
	}

	/**
	 * Optional. Service message: video chat started
	 *
	 * @return array
	 */
	public function getVideoChatStarted(): array
	{
		return (array)$this->getData("video_chat_started");
	}

	/**
	 * Optional. Service message: video chat ended
	 *
	 * @return array
	 */
	public function getVideoChatEnded(): array
	{
		return (array)$this->getData("video_chat_ended");
	}

	/**
	 * Optional. Service message: new participants invited to a video chat
	 *
	 * @return array
	 */
	public function getVideoChatParticipantsInvited(): array
	{
		return (array)$this->getData("video_chat_participants_invited");
	}

	/**
	 * Optional. Service message: data sent by a Web App
	 *
	 * @return array
	 */
	public function getWebAppData(): array
	{
		return (array)$this->getData("web_app_data");
	}

	/**
	 * Optional. Inline keyboard attached to the message. "login_url" buttons are represented as ordinary url buttons.
	 *
	 * @return array
	 */
	public function getReplyMarkup(): array
	{
		return (array)$this->getData("reply_markup");
	}

	/**
	 * Необязательно. Сведения о теме личных сообщений канала, содержащей сообщение.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getDirectMessagesTopic(): array
	{
		return (array)$this->getData("direct_messages_topic", []);
	}

	/**
	 * Необязательно. Метка или должность отправителя; только для супергрупп.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getSenderTag(): string|null
	{
		return $this->getData("sender_tag");
	}

	/**
	 * Необязательно. Пользователь, получивший эфемерное сообщение.
	 *
	 * @return User|null
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getReceiverUser(): User|null
	{
		$data = $this->getData("receiver_user");
		return $data === null ? null : new User($data);
	}

	/**
	 * Необязательно. Идентификатор эфемерного сообщения внутри чата; может использоваться повторно после удаления или истечения срока сообщения.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getEphemeralMessageId(): int|null
	{
		return $this->getData("ephemeral_message_id");
	}

	/**
	 * Необязательно. Уникальный идентификатор гостевого запроса для ответа через answerGuestQuery.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getGuestQueryId(): string|null
	{
		return $this->getData("guest_query_id");
	}

	/**
	 * Необязательно. Идентификатор задачи списка, на которую отправлен ответ.
	 *
	 * @return int|null
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getReplyToChecklistTaskId(): int|null
	{
		return $this->getData("reply_to_checklist_task_id");
	}

	/**
	 * Необязательно. Постоянный идентификатор варианта опроса, на который отправлен ответ.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getReplyToPollOptionId(): string|null
	{
		return $this->getData("reply_to_poll_option_id");
	}

	/**
	 * Необязательно. Пользователь, чьё сообщение вызвало ответ гостевого бота.
	 *
	 * @return User|null
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getGuestBotCallerUser(): User|null
	{
		$data = $this->getData("guest_bot_caller_user");
		return $data === null ? null : new User($data);
	}

	/**
	 * Необязательно. Чат, чьё сообщение вызвало ответ гостевого бота.
	 *
	 * @return Chat|null
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getGuestBotCallerChat(): Chat|null
	{
		$data = $this->getData("guest_bot_caller_chat");
		return $data === null ? null : new Chat($data);
	}

	/**
	 * Необязательно. True, если сообщение является платной публикацией; её нельзя редактировать или удалять в течение 24 часов для получения оплаты.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function isPaidPost(): bool
	{
		return (bool)$this->getData("is_paid_post");
	}

	/**
	 * Необязательно. Параметры предложенной публикации в личных сообщениях канала.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getSuggestedPostInfo(): array
	{
		return (array)$this->getData("suggested_post_info", []);
	}

	/**
	 * Необязательно. Сообщение с расширенным форматированием.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getRichMessage(): array
	{
		return (array)$this->getData("rich_message", []);
	}

	/**
	 * Необязательно. Живая фотография. При наличии этого поля также заполняется поле photo.
	 *
	 * @return LivePhoto|null
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getLivePhoto(): LivePhoto|null
	{
		$data = $this->getData("live_photo");
		return $data === null ? null : new LivePhoto($data);
	}

	/**
	 * Необязательно. Список задач.
	 *
	 * @return Checklist|null
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getChecklist(): Checklist|null
	{
		$data = $this->getData("checklist");
		return $data === null ? null : new Checklist($data);
	}

	/**
	 * Необязательно. Служебное сообщение: владелец покинул чат.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getChatOwnerLeft(): array
	{
		return (array)$this->getData("chat_owner_left", []);
	}

	/**
	 * Необязательно. Служебное сообщение: владелец чата изменился.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getChatOwnerChanged(): array
	{
		return (array)$this->getData("chat_owner_changed", []);
	}

	/**
	 * Необязательно. Служебное сообщение: улучшение подарка куплено после его отправки.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getGiftUpgradeSent(): array
	{
		return (array)$this->getData("gift_upgrade_sent", []);
	}

	/**
	 * Необязательно. Служебное сообщение: задачи отмечены выполненными или невыполненными.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getChecklistTasksDone(): array
	{
		return (array)$this->getData("checklist_tasks_done", []);
	}

	/**
	 * Необязательно. Служебное сообщение: в список добавлены задачи.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getChecklistTasksAdded(): array
	{
		return (array)$this->getData("checklist_tasks_added", []);
	}

	/**
	 * Необязательно. Служебное сообщение: чат или бот добавлен в сообщество.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getCommunityChatAdded(): array
	{
		return (array)$this->getData("community_chat_added", []);
	}

	/**
	 * Необязательно. Служебное сообщение: пользователь из сообщества вступил в чат.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getCommunityChatJoined(): array
	{
		return (array)$this->getData("community_chat_joined", []);
	}

	/**
	 * Необязательно. Служебное сообщение: чат или бот удалён из сообщества.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getCommunityChatRemoved(): array
	{
		return (array)$this->getData("community_chat_removed", []);
	}

	/**
	 * Необязательно. Служебное сообщение: изменена цена сообщений в личном чате канала.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getDirectMessagePriceChanged(): array
	{
		return (array)$this->getData("direct_message_price_changed", []);
	}

	/**
	 * Необязательно. Служебное сообщение: пользователь создал бота под управлением текущего бота.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getManagedBotCreated(): array
	{
		return (array)$this->getData("managed_bot_created", []);
	}

	/**
	 * Необязательно. Служебное сообщение: добавлен вариант ответа в опрос.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getPollOptionAdded(): array
	{
		return (array)$this->getData("poll_option_added", []);
	}

	/**
	 * Необязательно. Служебное сообщение: удалён вариант ответа из опроса.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getPollOptionDeleted(): array
	{
		return (array)$this->getData("poll_option_deleted", []);
	}

	/**
	 * Необязательно. Служебное сообщение: предложенная публикация одобрена.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getSuggestedPostApproved(): array
	{
		return (array)$this->getData("suggested_post_approved", []);
	}

	/**
	 * Необязательно. Служебное сообщение: одобрение предложенной публикации не удалось.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getSuggestedPostApprovalFailed(): array
	{
		return (array)$this->getData("suggested_post_approval_failed", []);
	}

	/**
	 * Необязательно. Служебное сообщение: предложенная публикация отклонена.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getSuggestedPostDeclined(): array
	{
		return (array)$this->getData("suggested_post_declined", []);
	}

	/**
	 * Необязательно. Служебное сообщение: получена оплата за предложенную публикацию.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getSuggestedPostPaid(): array
	{
		return (array)$this->getData("suggested_post_paid", []);
	}

	/**
	 * Необязательно. Служебное сообщение: оплата предложенной публикации возвращена.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#message
	 */
	public function getSuggestedPostRefunded(): array
	{
		return (array)$this->getData("suggested_post_refunded", []);
	}

}
