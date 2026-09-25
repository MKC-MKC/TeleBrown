<?php

namespace Haikiri\TeleBrown\Enums;

enum ChatMemberEnum: string
{

	case OWNER = "creator";
	case ADMINISTRATOR = "administrator";
	case MEMBER = "member";
	case RESTRICTED = "restricted";
	case LEFT = "left";
	case BANNED = "kicked";

}
