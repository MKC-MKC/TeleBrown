<?php

namespace Haikiri\TeleBrown\Enums;

enum MessageOriginEnum: string
{

	case USER = "user";
	case HIDDEN_USER = "hidden_user";
	case CHAT = "chat";
	case CHANNEL = "channel";

}
