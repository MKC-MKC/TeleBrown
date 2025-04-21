<?php

namespace Haikiri\TeleBrown\Enums;

enum ChatMemberEnum: string
{

	case OWNER = "owner";
	case ADMINISTRATOR = "administrator";
	case MEMBER = "member";
	case RESTRICTED = "restricted";
	case LEFT = "left";
	case BANNED = "kicked";

}
