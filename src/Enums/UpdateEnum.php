<?php

namespace Haikiri\TeleBrown\Enums;

/**
 * @see https://core.telegram.org/bots/api#update
 */
enum UpdateEnum: string
{

//	case UPDATE_ID = "update_id"; # Идентификатор обновления.
	case MESSAGE = "message"; # Новое сообщение.
	case EDITED_MESSAGE = "edited_message"; # Отредактированное сообщение.
	case CHANNEL_POST = "channel_post"; # Новое сообщение канала.
	case EDITED_CHANNEL_POST = "edited_channel_post"; # Отредактированное сообщение канала.
	case BUSINESS_CONNECTION = "business_connection"; # Подключение к бизнес-аккаунту.
	case BUSINESS_MESSAGE = "business_message"; # Сообщение от бизнес-аккаунта.
	case EDITED_BUSINESS_MESSAGE = "edited_business_message"; # Отредактированное сообщение от бизнес-аккаунта.
	case DELETED_BUSINESS_MESSAGES = "deleted_business_messages"; # Удаленные сообщения от бизнес-аккаунта.
	case MESSAGE_REACTION = "message_reaction"; # Реакция на сообщение.
	case MESSAGE_REACTION_COUNT = "message_reaction_count"; # Количество реакций на сообщение.
	case INLINE_QUERY = "inline_query"; # Входящий inline-запрос.
	case CHOSEN_INLINE_RESULT = "chosen_inline_result"; # Выбранный inline-результат.
	case CALLBACK_QUERY = "callback_query"; # Входящий callback-запрос.
	case SHIPPING_QUERY = "shipping_query"; # Входящий запрос на доставку.
	case PRE_CHECKOUT_QUERY = "pre_checkout_query"; # Входящий запрос на предзаказ.
	case PURCHASED_PAID_MEDIA = "purchased_paid_media"; # Приобретенные платные медиа.
	case POLL = "poll"; # Новое состояние опроса.
	case POLL_ANSWER = "poll_answer"; # Ответ на опрос.
	case MY_CHAT_MEMBER = "my_chat_member"; # Изменение статуса участника чата.
	case CHAT_MEMBER = "chat_member"; # Изменение статуса участника чата.
	case CHAT_JOIN_REQUEST = "chat_join_request"; # Запрос на присоединение к чату.
	case CHAT_BOOST = "chat_boost"; # Увеличение boost чата.
	case REMOVED_CHAT_BOOST = "removed_chat_boost"; # Удаление boost чата.

}
