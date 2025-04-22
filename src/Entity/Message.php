<?php /** @noinspection PhpUnused */

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use DateTimeImmutable;
use Haikiri\TeleBrown\Enums\MessageTypesEnum;

/**
 * Message – This object represents a message.
 * @see https://core.telegram.org/bots/api#message
 */
class Message extends MaybeInaccessibleMessage
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	/**
	 * Метод возвращает тип сообщения.
	 *
	 * @return MessageTypesEnum|null
	 */
	public function getType(): ?MessageTypesEnum
	{
		return match (true) {
			!empty($this->getAudio()) => MessageTypesEnum::AUDIO,
			!empty($this->getDocument()) => MessageTypesEnum::DOCUMENT,
			!empty($this->getAnimation()) => MessageTypesEnum::ANIMATION,
			!empty($this->getGame()) => MessageTypesEnum::GAME,
			!empty($this->getPhoto()) => MessageTypesEnum::PHOTO,
			!empty($this->getSticker()) => MessageTypesEnum::STICKER,
			!empty($this->getVideo()) => MessageTypesEnum::VIDEO,
			!empty($this->getVoice()) => MessageTypesEnum::VOICE,
			!empty($this->getVideoNote()) => MessageTypesEnum::VIDEO_NOTE,
			!empty($this->getContact()) => MessageTypesEnum::CONTACT,
			!empty($this->getLocation()) => MessageTypesEnum::LOCATION,
			!empty($this->getVenue()) => MessageTypesEnum::VENUE,
			!empty($this->getPoll()) => MessageTypesEnum::POLL,
			!empty($this->getDice()) => MessageTypesEnum::DICE,
			!empty($this->getNewChatMembers()) => MessageTypesEnum::NEW_CHAT_MEMBERS,
			!empty($this->getLeftChatMember()) => MessageTypesEnum::LEFT_CHAT_MEMBER,
			!empty($this->getNewChatTitle()) => MessageTypesEnum::NEW_CHAT_TITLE,
			!empty($this->getNewChatPhoto()) => MessageTypesEnum::NEW_CHAT_PHOTO,
			!empty($this->getMessageAutoDeleteTimerChanged()) => MessageTypesEnum::AUTO_DELETE_TIMER_CHANGED,
			!empty($this->getPinnedMessage()) => MessageTypesEnum::PINNED_MESSAGE,
			!empty($this->getInvoice()) => MessageTypesEnum::INVOICE,
			!empty($this->getSuccessfulPayment()) => MessageTypesEnum::SUCCESSFUL_PAYMENT,
			!empty($this->getUsersShared()) => MessageTypesEnum::USERS_SHARED,
			!empty($this->getChatShared()) => MessageTypesEnum::CHAT_SHARED,
			!empty($this->getConnectedWebsite()) => MessageTypesEnum::CONNECTED_WEBSITE,
			!empty($this->getWriteAccessAllowed()) => MessageTypesEnum::WRITE_ACCESS_ALLOWED,
			!empty($this->getPassportData()) => MessageTypesEnum::PASSPORT_DATA,
			!empty($this->getProximityAlertTriggered()) => MessageTypesEnum::PROXIMITY_ALERT_TRIGGERED,
			!empty($this->getForumTopicCreated()) => MessageTypesEnum::FORUM_TOPIC_CREATED,
			!empty($this->getForumTopicEdited()) => MessageTypesEnum::FORUM_TOPIC_EDITED,
			!empty($this->getForumTopicClosed()) => MessageTypesEnum::FORUM_TOPIC_CLOSED,
			!empty($this->getForumTopicReopened()) => MessageTypesEnum::FORUM_TOPIC_REOPENED,
			!empty($this->getGeneralForumTopicHidden()) => MessageTypesEnum::GENERAL_FORUM_TOPIC_HIDDEN,
			!empty($this->getGeneralForumTopicUnhidden()) => MessageTypesEnum::GENERAL_FORUM_TOPIC_UNHIDDEN,
			!empty($this->getGiveaway()) => MessageTypesEnum::GIVEAWAY,
			!empty($this->getGiveawayWinners()) => MessageTypesEnum::GIVEAWAY_WINNERS,
			!empty($this->getVideoChatScheduled()) => MessageTypesEnum::VIDEO_CHAT_SCHEDULED,
			!empty($this->getVideoChatStarted()) => MessageTypesEnum::VIDEO_CHAT_STARTED,
			!empty($this->getVideoChatEnded()) => MessageTypesEnum::VIDEO_CHAT_ENDED,
			!empty($this->getVideoChatParticipantsInvited()) => MessageTypesEnum::VIDEO_CHAT_PARTICIPANTS_INVITED,
			!empty($this->getText()) => MessageTypesEnum::TEXT,
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
		return (int)$this->getData("message_id") ?? 0;
	}

	/**
	 * Optional. Unique identifier of a message thread to which the message belongs; for supergroups only
	 *
	 * @return int
	 */
	public function getThreadId(): int
	{
		return (int)$this->getData("message_thread_id") ?? 0;
	}

	/**
	 * Type of the chat, can be either “private”, “group”, “supergroup” or “channel”
	 *
	 * @return User
	 */
	public function getFrom(): User
	{
		return new User($this->getData("from"));
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
		return new Chat($this->getData("sender_chat"));
	}

	/**
	 * Optional. If the sender of the message boosted the chat, the number of boosts added by the user
	 *
	 * @return int
	 */
	public function getSenderBoostCount(): int
	{
		return (int)$this->getData("sender_boost_count") ?? 0;
	}

	/**
	 * Optional. The bot that actually sent the message on behalf of the business account.
	 * Available only for outgoing messages sent on behalf of the connected business account.
	 *
	 * @return User
	 */
	public function getSenderBusinessBot(): User
	{
		return new User($this->getData("sender_business_bot"));
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
	 * Returns the date as a DateTimeImmutable object.
	 * TODO: Fix this method to return the correct DateTimeImmutable object
	 *
	 * @return DateTimeImmutable|null
	 */
//	public function getDateTime(): ?DateTimeImmutable
//	{
//		$dateString = $this->getData("date") ?? null;
//		if (empty($dateString)) return null;
//
//		return DateTimeImmutable::createFromFormat(format: "Y-m-d H:i:s", datetime: $dateString) ?: null;
//	}

	/**
	 * Optional. Unique identifier of the business connection from which the message was received.
	 * If non-empty, the message belongs to a chat of the corresponding business account that is independent,
	 * from any potential bot chat which might share the same identifier.
	 *
	 * @return string
	 */
	public function getBusinessConnectionId(): string
	{
		return (string)$this->getData("business_connection_id") ?? "";
	}

	/**
	 * Chat the message belongs to
	 *
	 * @return Chat
	 */
	public function getChat(): Chat
	{
		return new Chat($this->getData("chat"));
	}

	/**
	 * Optional. Information about the original message for forwarded messages
	 *
	 * @return array
	 */
	public function getForwardOrigin(): array
	{
		return (array)$this->getData("forward_origin") ?? [];
	}

	/**
	 * Optional. True, if the message is sent to a forum topic
	 *
	 * @return bool
	 */
	public function isTopicMessage(): bool
	{
		return ($this->getData("is_topic_message") ?? false);
	}

	/**
	 * Optional. True, if the message is a channel post that was automatically forwarded to the connected discussion group
	 *
	 * @return bool
	 */
	public function isAutomaticForward(): bool
	{
		return ($this->getData("is_automatic_forward") ?? false);
	}

	/**
	 * Optional. For replies in the same chat and message thread, the original message.
	 * Note that the Message object in this field will not contain further reply_to_message fields even if it itself is a reply.
	 *
	 * @return Message
	 */
	public function getReplyToMessage(): Message
	{
		return new Message($this->getData("reply_to_message"));
	}

	/**
	 * Optional. Information about the message that is being replied to, which may come from another chat or forum topic
	 *
	 * @return array
	 */
	public function getExternalReply(): array
	{
		return (array)$this->getData("external_reply") ?? [];
	}

	/**
	 * Optional. For replies that quote part of the original message, the quoted part of the message
	 *
	 * @return array
	 */
	public function getQuote(): array
	{
		return (array)$this->getData("quote") ?? [];
	}

	/**
	 * Optional. For replies to a story, the original story
	 *
	 * @return array
	 */
	public function getReplyToStory(): array
	{
		return (array)$this->getData("reply_to_story") ?? [];
	}

	/**
	 * Optional. Bot through which the message was sent
	 *
	 * @return User
	 */
	public function getViaBot(): User
	{
		return new User($this->getData("via_bot"));
	}

	/**
	 * Optional. Date the message was last edited in Unix time
	 *
	 * @return int
	 */
	public function getEditDate(): int
	{
		return (int)$this->getData("edit_date") ?? 0;
	}

	/**
	 * Returns the edit date as a DateTimeImmutable object.
	 *
	 * @return DateTimeImmutable|null
	 */
	public function getEditDateTime(): ?DateTimeImmutable
	{
		$dateString = $this->getData("edit_date") ?? null;
		if (empty($dateString)) return null;

		return DateTimeImmutable::createFromFormat(format: "Y-m-d H:i:s", datetime: $dateString) ?: null;
	}

	/**
	 * Optional. True, if the message can't be forwarded
	 */
	public function hasProtectedContent(): bool
	{
		return ($this->getData("has_protected_content") ?? false);
	}

	/**
	 * Optional. True, if the message was sent by an implicit action,
	 * for example, as an away or a greeting business message, or as a scheduled message
	 *
	 * @return bool
	 */
	public function isFromOffline(): bool
	{
		return ($this->getData("is_from_offline") ?? false);
	}

	/**
	 * Optional. The unique identifier of a media message group this message belongs to
	 *
	 * @return string
	 */
	public function getMediaGroupId(): string
	{
		return (string)$this->getData("media_group_id") ?? "";
	}

	/**
	 * Optional. Signature of the post author for messages in channels, or the custom title of an anonymous group administrator
	 *
	 * @return string
	 */
	public function getAuthorSignature(): string
	{
		return (string)$this->getData("author_signature") ?? "";
	}

	/**
	 * Optional. The number of Telegram Stars that were paid by the sender of the message to send it
	 *
	 * @return int
	 */
	public function getPaidStarCount(): int
	{
		return (int)$this->getData("paid_star_count") ?? 0;
	}

	/**
	 * Optional. For text messages, the actual UTF-8 text of the message
	 *
	 * @return string
	 */
	public function getText(): string
	{
		return (string)$this->getData("text") ?? "";
	}

	/**
	 * Optional. For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text
	 *
	 * @return array
	 */
	public function getEntities(): array
	{
		return (array)$this->getData("entities") ?? [];
	}

	/**
	 * Optional. Options used for link preview generation for the message, if it is a text message and link preview options were changed
	 *
	 * @return array
	 */
	public function getLinkPreviewOptions(): array
	{
		return (array)$this->getData("link_preview_options") ?? [];
	}

	/**
	 * Optional. Unique identifier of the message effect added to the message
	 *
	 * @return string
	 */
	public function getEffectId(): string
	{
		return (string)$this->getData("effect_id") ?? "";
	}

	/**
	 * Optional. Message is an animation, information about the animation.
	 * For backward compatibility, when this field is set, the document field will also be set
	 *
	 * @return array
	 */
	public function getAnimation(): array
	{
		return (array)$this->getData("animation") ?? [];
	}

	/**
	 * Optional. Message is an audio file, information about the file
	 *
	 * @return array
	 */
	public function getAudio(): array
	{
		return (array)$this->getData("audio") ?? [];
	}

	/**
	 * Optional. Message is a general file, information about the file
	 *
	 * @return array
	 */
	public function getDocument(): array
	{
		return (array)$this->getData("document") ?? [];
	}

	/**
	 * Optional. Message contains paid media; information about the paid media
	 *
	 * @return array
	 */
	public function getPaidMedia(): array
	{
		return (array)$this->getData("paid_media") ?? [];
	}

	/**
	 * Optional. Message is a photo, available sizes of the photo
	 *
	 * @return array
	 */
	public function getPhoto(): array
	{
		return (array)$this->getData("photo") ?? [];
	}

	/**
	 * Optional. Message is a sticker, information about the sticker
	 *
	 * @return array
	 */
	public function getSticker(): array
	{
		return (array)$this->getData("sticker") ?? [];
	}

	/**
	 * Optional. Message is a forwarded story
	 *
	 * @return array
	 */
	public function getStory(): array
	{
		return (array)$this->getData("story") ?? [];
	}

	/**
	 * Optional. Message is a video, information about the video
	 *
	 * @return array
	 */
	public function getVideo(): array
	{
		return (array)$this->getData("video") ?? [];
	}

	/**
	 * Optional. Message is a video note, information about the video message
	 *
	 * @return array
	 */
	public function getVideoNote(): array
	{
		return (array)$this->getData("video_note") ?? [];
	}

	/**
	 * Optional. Message is a voice message, information about the file
	 *
	 * @return array
	 */
	public function getVoice(): array
	{
		return (array)$this->getData("voice") ?? [];
	}

	/**
	 * Optional. Caption for the animation, audio, document, paid media, photo, video or voice
	 *
	 * @return string
	 */
	public function getCaption(): string
	{
		return (string)$this->getData("caption") ?? "";
	}

	/**
	 * Optional. For messages with a caption, special entities like usernames, URLs, bot commands, etc. that appear in the caption
	 *
	 * @return array
	 */
	public function getCaptionEntities(): array
	{
		return (array)$this->getData("caption_entities") ?? [];
	}

	/**
	 * Optional. True, if the caption must be shown above the message media
	 *
	 * @return bool
	 */
	public function showCaptionAboveMedia(): bool
	{
		return ($this->getData("show_caption_above_media") ?? false);
	}

	/**
	 * Optional. True, if the message media is covered by a spoiler animation
	 *
	 * @return bool
	 */
	public function hasMediaSpoiler(): bool
	{
		return ($this->getData("has_media_spoiler") ?? false);
	}

	/**
	 * Optional. Message is a shared contact, information about the contact
	 *
	 * @return Contact
	 */
	public function getContact(): Contact
	{
		return new Contact($this->getData("contact"));
	}

	/**
	 * Optional. Message is a 'dice' with random value
	 *
	 * @return array
	 */
	public function getDice(): array
	{
		return (array)$this->getData("dice") ?? [];
	}

	/**
	 * Optional. Message is a game, information about the game. More about games »
	 *
	 * @return array
	 */
	public function getGame(): array
	{
		return (array)$this->getData("game") ?? [];
	}

	/**
	 * Optional. Message is a native poll, information about the poll
	 *
	 * @return array
	 */
	public function getPoll(): array
	{
		return (array)$this->getData("poll") ?? [];
	}

	/**
	 * Optional. Message is a venue, information about the venue.
	 * For backward compatibility, when this field is set, the location field will also be set
	 *
	 * @return array
	 */
	public function getVenue(): array
	{
		return (array)$this->getData("venue") ?? [];
	}

	/**
	 * Optional. Message is a shared location, information about the location
	 *
	 * @return array
	 */
	public function getLocation(): array
	{
		return (array)$this->getData("location") ?? [];
	}

	/**
	 * Optional. New members that were added to the group or supergroup and information about them (the bot itself may be one of these members)
	 *
	 * @return array of User
	 */
	public function getNewChatMembers(): array
	{
		return (array)$this->getData("new_chat_members") ?? [];
	}

	/**
	 * Optional. A member was removed from the group, information about them (this member may be the bot itself)
	 *
	 * @return User
	 */
	public function getLeftChatMember(): User
	{
		return new User($this->getData("left_chat_member"));
	}

	/**
	 * Optional. A chat title was changed to this value
	 *
	 * @return string
	 */
	public function getNewChatTitle(): string
	{
		return (string)$this->getData("new_chat_title") ?? "";
	}

	/**
	 * Optional. A chat photo was change to this value
	 *
	 * @return array of PhotoSize
	 */
	public function getNewChatPhoto(): array
	{
		return (array)$this->getData("new_chat_photo") ?? [];
	}

	/**
	 * Optional. Service message: the chat photo was deleted
	 *
	 * @return bool
	 */
	public function deleteChatPhoto(): bool
	{
		return ($this->getData("delete_chat_photo") ?? false);
	}

	/**
	 * Optional. Service message: the group has been created
	 *
	 * @return bool
	 */
	public function isGroupChatCreated(): bool
	{
		return ($this->getData("group_chat_created") ?? false);
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
		return ($this->getData("supergroup_chat_created") ?? false);
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
		return ($this->getData("channel_chat_created") ?? false);
	}

	/**
	 * Optional. Service message: auto-delete timer settings changed in the chat
	 *
	 * @return array
	 */
	public function getMessageAutoDeleteTimerChanged(): array
	{
		return (array)$this->getData("message_auto_delete_timer_changed") ?? [];
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
		return (int)$this->getData("migrate_to_chat_id") ?? 0;
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
		return (int)$this->getData("migrate_from_chat_id") ?? 0;
	}

	/**
	 * Optional. Specified message was pinned.
	 * Note that the Message object in this field will not contain further reply_to_message fields even if it itself is a reply.
	 *
	 * @return array
	 */
	public function getPinnedMessage(): array
	{
		return (array)$this->getData("pinned_message") ?? [];
	}

	/**
	 * Optional. Message is an invoice for a payment, information about the invoice. More about payments »
	 *
	 * @return array
	 */
	public function getInvoice(): array
	{
		return (array)$this->getData("invoice") ?? [];
	}

	/**
	 * Optional. Message is a service message about a successful payment, information about the payment. More about payments »
	 *
	 * @return array
	 */
	public function getSuccessfulPayment(): array
	{
		return (array)$this->getData("successful_payment") ?? [];
	}

	/**
	 * Optional. Message is a service message about a refunded payment, information about the payment. More about payments »
	 *
	 * @return array
	 */
	public function getRefundedPayment(): array
	{
		return (array)$this->getData("refunded_payment") ?? [];
	}

	/**
	 * Optional. Service message: users were shared with the bot
	 *
	 * @return array
	 */
	public function getUsersShared(): array
	{
		return (array)$this->getData("users_shared") ?? [];
	}

	/**
	 * Optional. Service message: a chat was shared with the bot
	 *
	 * @return array
	 */
	public function getChatShared(): array
	{
		return (array)$this->getData("chat_shared") ?? [];
	}

	/**
	 * Optional. Service message: a regular gift was sent or received
	 *
	 * @return array
	 */
	public function getGift(): array
	{
		return (array)$this->getData("gift") ?? [];
	}

	/**
	 * Optional. Service message: a unique gift was sent or received
	 *
	 * @return array
	 */
	public function getUniqueGift(): array
	{
		return (array)$this->getData("unique_gift") ?? [];
	}

	/**
	 * Optional. The domain name of the website on which the user has logged in. More about Telegram Login »
	 *
	 * @return string
	 */
	public function getConnectedWebsite(): string
	{
		return (string)$this->getData("connected_website") ?? "";
	}

	/**
	 * Optional. Service message: the user allowed the bot to write messages after adding it to the attachment or side menu,
	 * launching a Web App from a link, or accepting an explicit request from a Web App sent by the method requestWriteAccess
	 *
	 * @return array
	 */
	public function getWriteAccessAllowed(): array
	{
		return (array)$this->getData("write_access_allowed") ?? [];
	}

	/**
	 * Optional. Telegram Passport data
	 *
	 * @return array
	 */
	public function getPassportData(): array
	{
		return (array)$this->getData("passport_data") ?? [];
	}

	/**
	 * Optional. Service message. A user in the chat triggered another user's proximity alert while sharing Live Location.
	 *
	 * @return array
	 */
	public function getProximityAlertTriggered(): array
	{
		return (array)$this->getData("proximity_alert_triggered") ?? [];
	}

	/**
	 * Optional. Service message: user boosted the chat
	 *
	 * @return array
	 */
	public function getBoostAdded(): array
	{
		return (array)$this->getData("boost_added") ?? [];
	}

	/**
	 * Optional. Service message: chat background set
	 *
	 * @return array
	 */
	public function getChatBackgroundSet(): array
	{
		return (array)$this->getData("chat_background_set") ?? [];
	}

	/**
	 * Optional. Service message: forum topic created
	 *
	 * @return array
	 */
	public function getForumTopicCreated(): array
	{
		return (array)$this->getData("forum_topic_created") ?? [];
	}

	/**
	 * Optional. Service message: forum topic edited
	 *
	 * @return array
	 */
	public function getForumTopicEdited(): array
	{
		return (array)$this->getData("forum_topic_edited") ?? [];
	}

	/**
	 * Optional. Service message: forum topic closed
	 *
	 * @return array
	 */
	public function getForumTopicClosed(): array
	{
		return (array)$this->getData("forum_topic_closed") ?? [];
	}

	/**
	 * Optional. Service message: forum topic reopened
	 *
	 * @return array
	 */
	public function getForumTopicReopened(): array
	{
		return (array)$this->getData("forum_topic_reopened") ?? [];
	}

	/**
	 * Optional. Service message: the 'General' forum topic hidden
	 *
	 * @return array
	 */
	public function getGeneralForumTopicHidden(): array
	{
		return (array)$this->getData("general_forum_topic_hidden") ?? [];
	}

	/**
	 * Optional. Service message: the 'General' forum topic unhidden
	 *
	 * @return array
	 */
	public function getGeneralForumTopicUnhidden(): array
	{
		return (array)$this->getData("general_forum_topic_unhidden") ?? [];
	}

	/**
	 * Optional. Service message: a scheduled giveaway was created
	 *
	 * @return array
	 */
	public function getGiveawayCreated(): array
	{
		return (array)$this->getData("giveaway_created") ?? [];
	}

	/**
	 * Optional. The message is a scheduled giveaway message
	 *
	 * @return array
	 */
	public function getGiveaway(): array
	{
		return (array)$this->getData("giveaway") ?? [];
	}

	/**
	 * Optional. A giveaway with public winners was completed
	 *
	 * @return array
	 */
	public function getGiveawayWinners(): array
	{
		return (array)$this->getData("giveaway_winners") ?? [];
	}

	/**
	 * Optional. Service message: a giveaway without public winners was completed
	 *
	 * @return array
	 */
	public function getGiveawayCompleted(): array
	{
		return (array)$this->getData("giveaway_completed") ?? [];
	}

	/**
	 * Optional. Service message: the price for paid messages has changed in the chat
	 *
	 * @return array
	 */
	public function getPaidMessagePriceChanged(): array
	{
		return (array)$this->getData("paid_message_price_changed") ?? [];
	}

	/**
	 * Optional. Service message: video chat scheduled
	 *
	 * @return array
	 */
	public function getVideoChatScheduled(): array
	{
		return (array)$this->getData("video_chat_scheduled") ?? [];
	}

	/**
	 * Optional. Service message: video chat started
	 *
	 * @return array
	 */
	public function getVideoChatStarted(): array
	{
		return (array)$this->getData("video_chat_started") ?? [];
	}

	/**
	 * Optional. Service message: video chat ended
	 *
	 * @return array
	 */
	public function getVideoChatEnded(): array
	{
		return (array)$this->getData("video_chat_ended") ?? [];
	}

	/**
	 * Optional. Service message: new participants invited to a video chat
	 *
	 * @return array
	 */
	public function getVideoChatParticipantsInvited(): array
	{
		return (array)$this->getData("video_chat_participants_invited") ?? [];
	}

	/**
	 * Optional. Service message: data sent by a Web App
	 *
	 * @return array
	 */
	public function getWebAppData(): array
	{
		return (array)$this->getData("web_app_data") ?? [];
	}

	/**
	 * Optional. Inline keyboard attached to the message. "login_url" buttons are represented as ordinary url buttons.
	 *
	 * @return array
	 */
	public function getReplyMarkup(): array
	{
		return (array)$this->getData("reply_markup") ?? [];
	}

}
