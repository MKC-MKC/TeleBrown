<?php

namespace Haikiri\TeleBrown\Enums;

enum InlineQueryChatEnum: string
{

	case SENDER = "sender";
	case PRIVATE = "private";
	case CHANNEL = "channel";
	case GROUP = "group";
	case SUPERGROUP = "supergroup";

}
