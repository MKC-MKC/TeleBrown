<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Generator;
use Haikiri\TeleBrown\ResponseWrapper;
use Haikiri\TeleBrown\Enums\UpdateEnum;

/**
 * Update – This object represents an incoming update.
 * @see https:core.telegram.org/bots/api#update
 */
class Update extends ResponseWrapper
{

	public function getId(): int
	{
		return (int)$this->getData("id");
	}

	public function getMessage(): Message
	{
		$data = (array)$this->getData("message", []);
		return new Message($data);
	}

	public function getEditedMessage(): Message
	{
		$data = (array)$this->getData("edited_message", []);
		return new Message($data);
	}

	public function getChannelPost(): Message
	{
		$data = (array)$this->getData("channel_post", []);
		return new Message($data);
	}

	public function getEditedChannelPost(): Message
	{
		$data = (array)$this->getData("edited_channel_post", []);
		return new Message($data);
	}

	public function getBusinessConnection(): BusinessConnection
	{
		$data = (array)$this->getData("business_connection", []);
		return new BusinessConnection($data);
	}

	public function getBusinessMessage(): Message
	{
		$data = (array)$this->getData("business_message", []);
		return new Message($data);
	}

	public function getEditedBusinessMessage(): Message
	{
		$data = (array)$this->getData("edited_business_message", []);
		return new Message($data);
	}

	public function getDeletedBusinessMessages(): BusinessMessagesDeleted
	{
		$data = (array)$this->getData("deleted_business_messages", []);
		return new BusinessMessagesDeleted($data);
	}

	public function getMessageReaction(): MessageReactionUpdated
	{
		$data = (array)$this->getData("message_reaction", []);
		return new MessageReactionUpdated($data);
	}

	public function getMessageReactionCount(): MessageReactionCountUpdated
	{
		$data = (array)$this->getData("message_reaction_count", []);
		return new MessageReactionCountUpdated($data);
	}

	public function getInlineQuery(): InlineQuery
	{
		$data = (array)$this->getData("inline_query", []);
		return new InlineQuery($data);
	}

	public function getChosenInlineResult(): ChosenInlineResult
	{
		$data = (array)$this->getData("chosen_inline_result", []);
		return new ChosenInlineResult($data);
	}

	public function getCallbackQuery(): CallbackQuery
	{
		$data = (array)$this->getData("callback_query", []);
		return new CallbackQuery($data);
	}

	public function getShippingQuery(): ShippingQuery
	{
		$data = (array)$this->getData("shipping_query", []);
		return new ShippingQuery($data);
	}

	public function getPreCheckoutQuery(): PreCheckoutQuery
	{
		$data = (array)$this->getData("pre_checkout_query", []);
		return new PreCheckoutQuery($data);
	}

	public function getPurchasedPaidMedia(): PaidMediaPurchased
	{
		$data = (array)$this->getData("purchased_paid_media", []);
		return new PaidMediaPurchased($data);
	}

	public function getPoll(): Poll
	{
		$data = (array)$this->getData("poll", []);
		return new Poll($data);
	}

	public function getPollAnswer(): PollAnswer
	{
		$data = (array)$this->getData("poll_answer", []);
		return new PollAnswer($data);
	}

	public function getMyChatMember(): ChatMemberUpdated
	{
		$data = (array)$this->getData("my_chat_member", []);
		return new ChatMemberUpdated($data);
	}

	public function getChatMember(): ChatMemberUpdated
	{
		$data = (array)$this->getData("chat_member", []);
		return new ChatMemberUpdated($data);
	}

	public function getChatJoinRequest(): ChatJoinRequest
	{
		$data = (array)$this->getData("chat_join_request", []);
		return new ChatJoinRequest($data);
	}

	public function getChatBoost(): ChatBoostUpdated
	{
		$data = (array)$this->getData("chat_boost", []);
		return new ChatBoostUpdated($data);
	}

	public function getRemovedChatBoost(): ChatBoostRemoved
	{
		$data = (array)$this->getData("removed_chat_boost", []);
		return new ChatBoostRemoved($data);
	}

	/**
	 * Метод для получения типа обновления.
	 *
	 * @return UpdateEnum|null
	 */
	public function getType(): UpdateEnum|null
	{
		return match (true) {
			!empty($this->getMessage()?->getAsArray()) => UpdateEnum::MESSAGE,
			!empty($this->getEditedMessage()?->getAsArray()) => UpdateEnum::EDITED_MESSAGE,
			!empty($this->getChannelPost()?->getAsArray()) => UpdateEnum::CHANNEL_POST,
			!empty($this->getEditedChannelPost()?->getAsArray()) => UpdateEnum::EDITED_CHANNEL_POST,
			!empty($this->getBusinessConnection()?->getAsArray()) => UpdateEnum::BUSINESS_CONNECTION,
			!empty($this->getBusinessMessage()?->getAsArray()) => UpdateEnum::BUSINESS_MESSAGE,
			!empty($this->getEditedBusinessMessage()?->getAsArray()) => UpdateEnum::EDITED_BUSINESS_MESSAGE,
			!empty($this->getDeletedBusinessMessages()?->getAsArray()) => UpdateEnum::DELETED_BUSINESS_MESSAGES,
			!empty($this->getMessageReaction()?->getAsArray()) => UpdateEnum::MESSAGE_REACTION,
			!empty($this->getMessageReactionCount()?->getAsArray()) => UpdateEnum::MESSAGE_REACTION_COUNT,
			!empty($this->getInlineQuery()?->getAsArray()) => UpdateEnum::INLINE_QUERY,
			!empty($this->getChosenInlineResult()?->getAsArray()) => UpdateEnum::CHOSEN_INLINE_RESULT,
			!empty($this->getCallbackQuery()?->getAsArray()) => UpdateEnum::CALLBACK_QUERY,
			!empty($this->getShippingQuery()?->getAsArray()) => UpdateEnum::SHIPPING_QUERY,
			!empty($this->getPreCheckoutQuery()?->getAsArray()) => UpdateEnum::PRE_CHECKOUT_QUERY,
			!empty($this->getPurchasedPaidMedia()?->getAsArray()) => UpdateEnum::PURCHASED_PAID_MEDIA,
			!empty($this->getPoll()?->getAsArray()) => UpdateEnum::POLL,
			!empty($this->getPollAnswer()?->getAsArray()) => UpdateEnum::POLL_ANSWER,
			!empty($this->getMyChatMember()?->getAsArray()) => UpdateEnum::MY_CHAT_MEMBER,
			!empty($this->getChatMember()?->getAsArray()) => UpdateEnum::CHAT_MEMBER,
			!empty($this->getChatJoinRequest()?->getAsArray()) => UpdateEnum::CHAT_JOIN_REQUEST,
			!empty($this->getChatBoost()?->getAsArray()) => UpdateEnum::CHAT_BOOST,
			!empty($this->getRemovedChatBoost()?->getAsArray()) => UpdateEnum::REMOVED_CHAT_BOOST,
			default => null,
		};
	}

	/**
	 * Метод возвращает актуальный объект чата.
	 *
	 * @return Chat|null
	 */
	public function getChat(): Chat|null
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
			if (is_object($object) && method_exists($object, "getChat")) {
				$chat = $object->getChat();
				if ($chat !== null && method_exists($chat, "getId") && !empty($chat->getId())) return $chat;
			}
		}

		return null;
	}

	/**
	 * Метод возвращает актуальный объект пользователя.
	 *
	 * @return User|null
	 */
	public function getUser(): User|null
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
				$user = $object?->$method();
				if (isset($user) && $user->getId() !== null) return $user;
			}
		}

		return null;
	}

	/**
	 * Метод возвращает актуальный объект сообщения.
	 *
	 * @return User|null
	 */
	public function getActualMessage(): Message|null
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
			if ($message !== null && method_exists($message, "getId") && !empty($message->getId())) return $message;
		}

		return null;
	}

	/**
	 * Метод возвращает актуальное время запроса в (int)UNIX-формате.
	 *
	 * @return int|null
	 */
	public function getDate(): int|null
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
				$value = $object?->$method();
				if (isset($value) && is_numeric($value)) return (int)$value;
			}
		}

		return null;
	}

}
