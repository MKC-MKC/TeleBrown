<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Generator;
use Haikiri\TeleBrown\Enums\UpdateEnum;

/**
 * Update – This object represents an incoming update.
 * @see https:core.telegram.org/bots/api#update
 */
class Update
{
	private array $response;

	public function __construct(array $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array
	{
		return $this->response ?? [];
	}

	public function getId(): int
	{
		return (int)$this->getAsArray()["id"] ?? 0;
	}

	public function getMessage(): Message
	{
		return new Message($this->getAsArray()["message"] ?? []);
	}

	public function getEditedMessage(): Message
	{
		return new Message($this->getAsArray()["edited_message"] ?? []);
	}

	public function getChannelPost(): Message
	{
		return new Message($this->getAsArray()["channel_post"] ?? []);
	}

	public function getEditedChannelPost(): Message
	{
		return new Message($this->getAsArray()["edited_channel_post"] ?? []);
	}

	public function getBusinessConnection(): BusinessConnection
	{
		return new BusinessConnection($this->getAsArray()["business_connection"] ?? []);
	}

	public function getBusinessMessage(): Message
	{
		return new Message($this->getAsArray()["business_message"] ?? []);
	}

	public function getEditedBusinessMessage(): Message
	{
		return new Message($this->getAsArray()["edited_business_message"] ?? []);
	}

	public function getDeletedBusinessMessages(): BusinessMessagesDeleted
	{
		return new BusinessMessagesDeleted($this->getAsArray()["deleted_business_messages"] ?? []);
	}

	public function getMessageReaction(): MessageReactionUpdated
	{
		return new MessageReactionUpdated($this->getAsArray()["message_reaction"] ?? []);
	}

	public function getMessageReactionCount(): MessageReactionCountUpdated
	{
		return new MessageReactionCountUpdated($this->getAsArray()["message_reaction_count"] ?? []);
	}

	public function getInlineQuery(): InlineQuery
	{
		return new InlineQuery($this->getAsArray()["inline_query"] ?? []);
	}

	public function getChosenInlineResult(): ChosenInlineResult
	{
		return new ChosenInlineResult($this->getAsArray()["chosen_inline_result"] ?? []);
	}

	public function getCallbackQuery(): CallbackQuery
	{
		return new CallbackQuery($this->getAsArray()["callback_query"] ?? []);
	}

	public function getShippingQuery(): ShippingQuery
	{
		return new ShippingQuery($this->getAsArray()["shipping_query"] ?? []);
	}

	public function getPreCheckoutQuery(): PreCheckoutQuery
	{
		return new PreCheckoutQuery($this->getAsArray()["pre_checkout_query"] ?? []);
	}

	public function getPurchasedPaidMedia(): PaidMediaPurchased
	{
		return new PaidMediaPurchased($this->getAsArray()["purchased_paid_media"] ?? []);
	}

	public function getPoll(): Poll
	{
		return new Poll($this->getAsArray()["poll"] ?? []);
	}

	public function getPollAnswer(): PollAnswer
	{
		return new PollAnswer($this->getAsArray()["poll_answer"] ?? []);
	}

	public function getMyChatMember(): ChatMemberUpdated
	{
		return new ChatMemberUpdated($this->getAsArray()["my_chat_member"] ?? []);
	}

	public function getChatMember(): ChatMemberUpdated
	{
		return new ChatMemberUpdated($this->getAsArray()["chat_member"] ?? []);
	}

	public function getChatJoinRequest(): ChatJoinRequest
	{
		return new ChatJoinRequest($this->getAsArray()["chat_join_request"] ?? []);
	}

	public function getChatBoost(): ChatBoostUpdated
	{
		return new ChatBoostUpdated($this->getAsArray()["chat_boost"] ?? []);
	}

	public function getRemovedChatBoost(): ChatBoostRemoved
	{
		return new ChatBoostRemoved($this->getAsArray()["removed_chat_boost"] ?? []);
	}

	/**
	 * Метод для получения типа обновления.
	 *
	 * @return UpdateEnum|null
	 */
	public function getType(): UpdateEnum|null
	{
		return match (true) {
			!empty($this->getMessage()->getAsArray()) => UpdateEnum::MESSAGE,
			!empty($this->getEditedMessage()->getAsArray()) => UpdateEnum::EDITED_MESSAGE,
			!empty($this->getChannelPost()->getAsArray()) => UpdateEnum::CHANNEL_POST,
			!empty($this->getEditedChannelPost()->getAsArray()) => UpdateEnum::EDITED_CHANNEL_POST,
			!empty($this->getBusinessConnection()->getAsArray()) => UpdateEnum::BUSINESS_CONNECTION,
			!empty($this->getBusinessMessage()->getAsArray()) => UpdateEnum::BUSINESS_MESSAGE,
			!empty($this->getEditedBusinessMessage()->getAsArray()) => UpdateEnum::EDITED_BUSINESS_MESSAGE,
			!empty($this->getDeletedBusinessMessages()->getAsArray()) => UpdateEnum::DELETED_BUSINESS_MESSAGES,
			!empty($this->getMessageReaction()->getAsArray()) => UpdateEnum::MESSAGE_REACTION,
			!empty($this->getMessageReactionCount()->getAsArray()) => UpdateEnum::MESSAGE_REACTION_COUNT,
			!empty($this->getInlineQuery()->getAsArray()) => UpdateEnum::INLINE_QUERY,
			!empty($this->getChosenInlineResult()->getAsArray()) => UpdateEnum::CHOSEN_INLINE_RESULT,
			!empty($this->getCallbackQuery()->getAsArray()) => UpdateEnum::CALLBACK_QUERY,
			!empty($this->getShippingQuery()->getAsArray()) => UpdateEnum::SHIPPING_QUERY,
			!empty($this->getPreCheckoutQuery()->getAsArray()) => UpdateEnum::PRE_CHECKOUT_QUERY,
			!empty($this->getPurchasedPaidMedia()->getAsArray()) => UpdateEnum::PURCHASED_PAID_MEDIA,
			!empty($this->getPoll()->getAsArray()) => UpdateEnum::POLL,
			!empty($this->getPollAnswer()->getAsArray()) => UpdateEnum::POLL_ANSWER,
			!empty($this->getMyChatMember()->getAsArray()) => UpdateEnum::MY_CHAT_MEMBER,
			!empty($this->getChatMember()->getAsArray()) => UpdateEnum::CHAT_MEMBER,
			!empty($this->getChatJoinRequest()->getAsArray()) => UpdateEnum::CHAT_JOIN_REQUEST,
			!empty($this->getChatBoost()->getAsArray()) => UpdateEnum::CHAT_BOOST,
			!empty($this->getRemovedChatBoost()->getAsArray()) => UpdateEnum::REMOVED_CHAT_BOOST,
			default => null,
		};
	}

	public function getChat(): ?Chat
	{
		foreach (
			(function (): Generator {
				yield $this->getMessage();
				yield $this->getEditedMessage();
				yield $this->getChannelPost();
				yield $this->getEditedChannelPost();
				yield $this->getBusinessMessage();
				yield $this->getEditedBusinessMessage();
				yield $this->getDeletedBusinessMessages();
				yield $this->getMessageReaction();
				yield $this->getMessageReactionCount();
				yield $this->getCallbackQuery()?->getMessage();
				yield $this->getMyChatMember();
				yield $this->getChatMember();
				yield $this->getChatJoinRequest();
				yield $this->getChatBoost();
				yield $this->getRemovedChatBoost();
			})
			() as $object) {
			if (!empty($object->getChat())) {
				return $object->getChat();
			}
		}

		return null;
	}

}
