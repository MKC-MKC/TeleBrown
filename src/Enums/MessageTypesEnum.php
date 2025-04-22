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

}
