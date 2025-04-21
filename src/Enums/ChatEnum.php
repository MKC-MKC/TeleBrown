<?php

namespace Haikiri\TeleBrown\Enums;

/**
 * @see https://core.telegram.org/bots/api#chat
 */
enum ChatEnum: string
{

	case PRIVATE = "private";
	case CHANNEL = "channel";
	case GROUP = "group";
	case SUPERGROUP = "supergroup";

}
