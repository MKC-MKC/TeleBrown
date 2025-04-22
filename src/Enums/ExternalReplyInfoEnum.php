<?php

namespace Haikiri\TeleBrown\Enums;

# TODO
enum ExternalReplyInfoEnum: string
{

	case ORIGIN = "origin";
	case CHAT = "chat";
	case MESSAGE_ID = "message_id";
	case LINK_PREVIEW_OPTIONS = "link_preview_options";
	case ANIMATION = "animation";
	case AUDIO = "audio";
	case DOCUMENT = "document";
	case PAID_MEDIA = "paid_media";
	case PHOTO = "photo";
	case STICKER = "sticker";
	case STORY = "story";
	case VIDEO = "video";
	case VIDEO_NOTE = "video_note";
	case VOICE = "voice";
	case HAS_MEDIA_SPOILER = "has_media_spoiler";
	case CONTACT = "contact";
	case DICE = "dice";
	case GAME = "game";
	case GIVEAWAY = "giveaway";
	case GIVEAWAY_WINNERS = "giveaway_winners";
	case INVOICE = "invoice";
	case LOCATION = "location";
	case POLL = "poll";
	case VENUE = "venue";

}
