<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Generator;
use Haikiri\TeleBrown\Type;
use Haikiri\TeleBrown\Enums\UpdateEnum;

/**
 * Update – This object represents an incoming update.
 * @see https:core.telegram.org/bots/api#update
 */
class Update extends Type
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	public function getId(): int
	{
		return (int)$this->getData("id") ?? 0;
	}

	public function getMessage(): Message
	{
		return new Message($this->getData("message"));
	}

	public function getEditedMessage(): Message
	{
		return new Message($this->getData("edited_message"));
	}

	public function getChannelPost(): Message
	{
		return new Message($this->getData("channel_post"));
	}

	public function getEditedChannelPost(): Message
	{
		return new Message($this->getData("edited_channel_post"));
	}

	public function getBusinessConnection(): BusinessConnection
	{
		return new BusinessConnection($this->getData("business_connection"));
	}

	public function getBusinessMessage(): Message
	{
		return new Message($this->getData("business_message"));
	}

	public function getEditedBusinessMessage(): Message
	{
		return new Message($this->getData("edited_business_message"));
	}

	public function getDeletedBusinessMessages(): BusinessMessagesDeleted
	{
		return new BusinessMessagesDeleted($this->getData("deleted_business_messages"));
	}

	public function getMessageReaction(): MessageReactionUpdated
	{
		return new MessageReactionUpdated($this->getData("message_reaction"));
	}

	public function getMessageReactionCount(): MessageReactionCountUpdated
	{
		return new MessageReactionCountUpdated($this->getData("message_reaction_count"));
	}

	public function getInlineQuery(): InlineQuery
	{
		return new InlineQuery($this->getData("inline_query"));
	}

	public function getChosenInlineResult(): ChosenInlineResult
	{
		return new ChosenInlineResult($this->getData("chosen_inline_result"));
	}

	public function getCallbackQuery(): CallbackQuery
	{
		return new CallbackQuery($this->getData("callback_query"));
	}

	public function getShippingQuery(): ShippingQuery
	{
		return new ShippingQuery($this->getData("shipping_query"));
	}

	public function getPreCheckoutQuery(): PreCheckoutQuery
	{
		return new PreCheckoutQuery($this->getData("pre_checkout_query"));
	}

	public function getPurchasedPaidMedia(): PaidMediaPurchased
	{
		return new PaidMediaPurchased($this->getData("purchased_paid_media"));
	}

	public function getPoll(): Poll
	{
		return new Poll($this->getData("poll"));
	}

	public function getPollAnswer(): PollAnswer
	{
		return new PollAnswer($this->getData("poll_answer"));
	}

	public function getMyChatMember(): ChatMemberUpdated
	{
		return new ChatMemberUpdated($this->getData("my_chat_member"));
	}

	public function getChatMember(): ChatMemberUpdated
	{
		return new ChatMemberUpdated($this->getData("chat_member"));
	}

	public function getChatJoinRequest(): ChatJoinRequest
	{
		return new ChatJoinRequest($this->getData("chat_join_request"));
	}

	public function getChatBoost(): ChatBoostUpdated
	{
		return new ChatBoostUpdated($this->getData("chat_boost"));
	}

	public function getRemovedChatBoost(): ChatBoostRemoved
	{
		return new ChatBoostRemoved($this->getData("removed_chat_boost"));
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

	/**
	 * Метод возвращает актуальный объект чата.
	 *
	 * @return Chat|null
	 */
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
			if (!is_object($object) || !method_exists(object_or_class: $object, method: __FUNCTION__)) continue;
			if (!empty($object->getChat()->getId())) return $object->getChat();
		}

		return null;
	}

	/**
	 * Метод возвращает актуальный объект пользователя.
	 *
	 * @return User|null
	 */
	public function getUser(): ?User
	{
		foreach (
			(function (): Generator {
				yield $this->getMessage();
				yield $this->getEditedMessage();
				yield $this->getChannelPost();
				yield $this->getEditedChannelPost();
				yield $this->getBusinessConnection();
				yield $this->getBusinessMessage();
				yield $this->getEditedBusinessMessage();
				yield $this->getDeletedBusinessMessages();
				yield $this->getMessageReaction();
				yield $this->getMessageReactionCount();
				yield $this->getInlineQuery();
				yield $this->getChosenInlineResult();
				yield $this->getCallbackQuery();
				yield $this->getShippingQuery();
				yield $this->getPreCheckoutQuery();
				yield $this->getPurchasedPaidMedia();
				yield $this->getPoll();
				yield $this->getPollAnswer();
				yield $this->getMyChatMember();
				yield $this->getChatMember();
				yield $this->getChatJoinRequest();
				yield $this->getChatBoost();
				yield $this->getRemovedChatBoost();
			})
			() as $object) {
			foreach (["getFrom", "getUser"] as $method) {
				if (is_object($object) && method_exists($object, $method)) {
					$user = $object->$method();
					if (!empty($user->getId())) return $user;
				}
			}
		}

		return null;
	}

	/**
	 * Метод возвращает актуальный объект сообщения.
	 *
	 * @return User|null
	 */
	public function getActualMessage(): ?Message
	{
		foreach (
			(function (): Generator {
				yield $this->getMessage();
				yield $this->getEditedMessage();
				yield $this->getChannelPost();
				yield $this->getEditedChannelPost();
				yield $this->getBusinessMessage();
				yield $this->getEditedBusinessMessage();
				yield $this->getCallbackQuery()?->getMessage();
			})
			() as $message) {
			if (!empty($message->getId())) return $message;
		}

		return null;
	}

	/**
	 * Метод возвращает актуальное время запроса в (int)UNIX-формате.
	 *
	 * @return int|null
	 */
	public function getDate(): ?int
	{
		foreach (
			(function (): Generator {
				yield $this->getMessage();
				yield $this->getEditedMessage();
				yield $this->getChannelPost();
				yield $this->getEditedChannelPost();
				yield $this->getBusinessConnection();
				yield $this->getBusinessMessage();
				yield $this->getEditedBusinessMessage();
				yield $this->getMessageReaction();
				yield $this->getMessageReactionCount();
				yield $this->getMyChatMember();
				yield $this->getChatMember();
				yield $this->getChatJoinRequest();
			})
			() as $object) {
			foreach (["getDate", "getEditDate", "getEditDateTime"] as $method) {
				if (is_object($object) && method_exists($object, $method)) {
					$value = $object->$method();
					if (!empty($value)) return (int)$value;
				}
			}
		}

		return null;
	}

}
