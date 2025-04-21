<?php

namespace Haikiri\TeleBrown;

abstract class TeleBrownClientAbstract
{
	public static bool $debug = false;

	/**
	 * Метод возвращает объект обновления.
	 *
	 * @return Entity\Update
	 */
	public function getUpdate(): Entity\Update
	{
		return new Entity\Update(response: $this->getUpdates());
	}

	/**
	 * Метод возвращает данные из входящего запроса.
	 *
	 * @return array
	 */
	public function getUpdates(): array
	{
		$response = $this->getResponse();
		if (empty($response)) return [];

		$result = json_decode($response, true);
		return $result ?? [];
	}

	/**
	 * Метод для получения типа обновления.
	 *
	 * @return Enums\UpdateEnum|null
	 */
	public function getUpdateType(): Enums\UpdateEnum|null
	{
		$update = $this->getUpdate();

		return match (true) {
			!empty($update->getMessage()->getAsArray()) => Enums\UpdateEnum::MESSAGE,
			!empty($update->getEditedMessage()->getAsArray()) => Enums\UpdateEnum::EDITED_MESSAGE,
			!empty($update->getChannelPost()->getAsArray()) => Enums\UpdateEnum::CHANNEL_POST,
			!empty($update->getEditedChannelPost()->getAsArray()) => Enums\UpdateEnum::EDITED_CHANNEL_POST,
			!empty($update->getBusinessConnection()->getAsArray()) => Enums\UpdateEnum::BUSINESS_CONNECTION,
			!empty($update->getBusinessMessage()->getAsArray()) => Enums\UpdateEnum::BUSINESS_MESSAGE,
			!empty($update->getEditedBusinessMessage()->getAsArray()) => Enums\UpdateEnum::EDITED_BUSINESS_MESSAGE,
			!empty($update->getDeletedBusinessMessages()->getAsArray()) => Enums\UpdateEnum::DELETED_BUSINESS_MESSAGES,
			!empty($update->getMessageReaction()->getAsArray()) => Enums\UpdateEnum::MESSAGE_REACTION,
			!empty($update->getMessageReactionCount()->getAsArray()) => Enums\UpdateEnum::MESSAGE_REACTION_COUNT,
			!empty($update->getInlineQuery()->getAsArray()) => Enums\UpdateEnum::INLINE_QUERY,
			!empty($update->getChosenInlineResult()->getAsArray()) => Enums\UpdateEnum::CHOSEN_INLINE_RESULT,
			!empty($update->getCallbackQuery()->getAsArray()) => Enums\UpdateEnum::CALLBACK_QUERY,
			!empty($update->getShippingQuery()->getAsArray()) => Enums\UpdateEnum::SHIPPING_QUERY,
			!empty($update->getPreCheckoutQuery()->getAsArray()) => Enums\UpdateEnum::PRE_CHECKOUT_QUERY,
			!empty($update->getPurchasedPaidMedia()->getAsArray()) => Enums\UpdateEnum::PURCHASED_PAID_MEDIA,
			!empty($update->getPoll()->getAsArray()) => Enums\UpdateEnum::POLL,
			!empty($update->getPollAnswer()->getAsArray()) => Enums\UpdateEnum::POLL_ANSWER,
			!empty($update->getMyChatMember()->getAsArray()) => Enums\UpdateEnum::MY_CHAT_MEMBER,
			!empty($update->getChatMember()->getAsArray()) => Enums\UpdateEnum::CHAT_MEMBER,
			!empty($update->getChatJoinRequest()->getAsArray()) => Enums\UpdateEnum::CHAT_JOIN_REQUEST,
			!empty($update->getChatBoost()->getAsArray()) => Enums\UpdateEnum::CHAT_BOOST,
			!empty($update->getRemovedChatBoost()->getAsArray()) => Enums\UpdateEnum::REMOVED_CHAT_BOOST,
			default => null,
		};
	}

}
