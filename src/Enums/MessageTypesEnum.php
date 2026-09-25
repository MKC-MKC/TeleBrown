<?php

namespace Haikiri\TeleBrown\Enums;

enum MessageTypesEnum: string
{

	case TEXT = "text";
	case AUDIO = "audio";
	case DOCUMENT = "document";
	case ANIMATION = "animation";
	case GAME = "game";
	case PHOTO = "photo";
	case STICKER = "sticker";
	case VIDEO = "video";
	case VOICE = "voice";
	case VIDEO_NOTE = "video_note";
	case CONTACT = "contact";
	case LOCATION = "location";
	case VENUE = "venue";
	case POLL = "poll";
	case DICE = "dice";
	case NEW_CHAT_MEMBERS = "new_chat_members";
	case LEFT_CHAT_MEMBER = "left_chat_member";
	case NEW_CHAT_TITLE = "new_chat_title";
	case NEW_CHAT_PHOTO = "new_chat_photo";
	case AUTO_DELETE_TIMER_CHANGED = "message_auto_delete_timer_changed";
	case PINNED_MESSAGE = "pinned_message";
	case INVOICE = "invoice";
	case SUCCESSFUL_PAYMENT = "successful_payment";
	case USERS_SHARED = "users_shared";
	case CHAT_SHARED = "chat_shared";
	case CONNECTED_WEBSITE = "connected_website";
	case WRITE_ACCESS_ALLOWED = "write_access_allowed";
	case PASSPORT_DATA = "passport_data";
	case PROXIMITY_ALERT_TRIGGERED = "proximity_alert_triggered";
	case FORUM_TOPIC_CREATED = "forum_topic_created";
	case FORUM_TOPIC_EDITED = "forum_topic_edited";
	case FORUM_TOPIC_CLOSED = "forum_topic_closed";
	case FORUM_TOPIC_REOPENED = "forum_topic_reopened";
	case GENERAL_FORUM_TOPIC_HIDDEN = "general_forum_topic_hidden";
	case GENERAL_FORUM_TOPIC_UNHIDDEN = "general_forum_topic_unhidden";
	case GIVEAWAY = "giveaway";
	case GIVEAWAY_WINNERS = "giveaway_winners";
	case VIDEO_CHAT_SCHEDULED = "video_chat_scheduled";
	case VIDEO_CHAT_STARTED = "video_chat_started";
	case VIDEO_CHAT_ENDED = "video_chat_ended";
	case VIDEO_CHAT_PARTICIPANTS_INVITED = "video_chat_participants_invited";
	case RICH_MESSAGE = "rich_message";
	case LIVE_PHOTO = "live_photo";
	case CHECKLIST = "checklist";
	case PAID_MEDIA = "paid_media";
	case STORY = "story";
	case DELETE_CHAT_PHOTO = "delete_chat_photo";
	case GROUP_CHAT_CREATED = "group_chat_created";
	case SUPERGROUP_CHAT_CREATED = "supergroup_chat_created";
	case CHANNEL_CHAT_CREATED = "channel_chat_created";
	case MIGRATE_TO_CHAT_ID = "migrate_to_chat_id";
	case MIGRATE_FROM_CHAT_ID = "migrate_from_chat_id";
	case REFUNDED_PAYMENT = "refunded_payment";
	case GIFT = "gift";
	case UNIQUE_GIFT = "unique_gift";
	case GIFT_UPGRADE_SENT = "gift_upgrade_sent";
	case CHAT_OWNER_LEFT = "chat_owner_left";
	case CHAT_OWNER_CHANGED = "chat_owner_changed";
	case CHECKLIST_TASKS_DONE = "checklist_tasks_done";
	case CHECKLIST_TASKS_ADDED = "checklist_tasks_added";
	case COMMUNITY_CHAT_ADDED = "community_chat_added";
	case COMMUNITY_CHAT_JOINED = "community_chat_joined";
	case COMMUNITY_CHAT_REMOVED = "community_chat_removed";
	case DIRECT_MESSAGE_PRICE_CHANGED = "direct_message_price_changed";
	case MANAGED_BOT_CREATED = "managed_bot_created";
	case POLL_OPTION_ADDED = "poll_option_added";
	case POLL_OPTION_DELETED = "poll_option_deleted";
	case SUGGESTED_POST_APPROVED = "suggested_post_approved";
	case SUGGESTED_POST_APPROVAL_FAILED = "suggested_post_approval_failed";
	case SUGGESTED_POST_DECLINED = "suggested_post_declined";
	case SUGGESTED_POST_PAID = "suggested_post_paid";
	case SUGGESTED_POST_REFUNDED = "suggested_post_refunded";
	case BOOST_ADDED = "boost_added";
	case CHAT_BACKGROUND_SET = "chat_background_set";
	case GIVEAWAY_CREATED = "giveaway_created";
	case GIVEAWAY_COMPLETED = "giveaway_completed";
	case WEB_APP_DATA = "web_app_data";

}
