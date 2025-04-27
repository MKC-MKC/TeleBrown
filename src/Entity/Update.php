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

	public function getMessage(): ?Message
	{
		return ($data = $this->getData("message")) && is_array($data) ? new Message($data) : null;
	}

	public function getEditedMessage(): ?Message
	{
		return ($data = $this->getData("edited_message")) && is_array($data) ? new Message($data) : null;
	}

	public function getChannelPost(): ?Message
	{
		return ($data = $this->getData("channel_post")) && is_array($data) ? new Message($data) : null;
	}

	public function getEditedChannelPost(): ?Message
	{
		return ($data = $this->getData("edited_channel_post")) && is_array($data) ? new Message($data) : null;
	}

	public function getBusinessConnection(): ?BusinessConnection
	{
		return ($data = $this->getData("business_connection")) && is_array($data) ? new BusinessConnection($data) : null;
	}

	public function getBusinessMessage(): ?Message
	{
		return ($data = $this->getData("business_message")) && is_array($data) ? new Message($data) : null;
	}

	public function getEditedBusinessMessage(): ?Message
	{
		return ($data = $this->getData("edited_business_message")) && is_array($data) ? new Message($data) : null;
	}

	public function getDeletedBusinessMessages(): ?BusinessMessagesDeleted
	{
		return ($data = $this->getData("deleted_business_messages")) && is_array($data) ? new BusinessMessagesDeleted($data) : null;
	}

	public function getMessageReaction(): ?MessageReactionUpdated
	{
		return ($data = $this->getData("message_reaction")) && is_array($data) ? new MessageReactionUpdated($data) : null;
	}

	public function getMessageReactionCount(): ?MessageReactionCountUpdated
	{
		return ($data = $this->getData("message_reaction_count")) && is_array($data) ? new MessageReactionCountUpdated($data) : null;
	}

	public function getInlineQuery(): ?InlineQuery
	{
		return ($data = $this->getData("inline_query")) && is_array($data) ? new InlineQuery($data) : null;
	}

	public function getChosenInlineResult(): ?ChosenInlineResult
	{
		return ($data = $this->getData("chosen_inline_result")) && is_array($data) ? new ChosenInlineResult($data) : null;
	}

	public function getCallbackQuery(): ?CallbackQuery
	{
		return ($data = $this->getData("callback_query")) && is_array($data) ? new CallbackQuery($data) : null;
	}

	public function getShippingQuery(): ?ShippingQuery
	{
		return ($data = $this->getData("shipping_query")) && is_array($data) ? new ShippingQuery($data) : null;
	}

	public function getPreCheckoutQuery(): ?PreCheckoutQuery
	{
		return ($data = $this->getData("pre_checkout_query")) && is_array($data) ? new PreCheckoutQuery($data) : null;
	}

	public function getPurchasedPaidMedia(): ?PaidMediaPurchased
	{
		return ($data = $this->getData("purchased_paid_media")) && is_array($data) ? new PaidMediaPurchased($data) : null;
	}

	public function getPoll(): ?Poll
	{
		return ($data = $this->getData("poll")) && is_array($data) ? new Poll($data) : null;
	}

	public function getPollAnswer(): ?PollAnswer
	{
		return ($data = $this->getData("poll_answer")) && is_array($data) ? new PollAnswer($data) : null;
	}

	public function getMyChatMember(): ?ChatMemberUpdated
	{
		return ($data = $this->getData("my_chat_member")) && is_array($data) ? new ChatMemberUpdated($data) : null;
	}

	public function getChatMember(): ?ChatMemberUpdated
	{
		return ($data = $this->getData("chat_member")) && is_array($data) ? new ChatMemberUpdated($data) : null;
	}

	public function getChatJoinRequest(): ?ChatJoinRequest
	{
		return ($data = $this->getData("chat_join_request")) && is_array($data) ? new ChatJoinRequest($data) : null;
	}

	public function getChatBoost(): ?ChatBoostUpdated
	{
		return ($data = $this->getData("chat_boost")) && is_array($data) ? new ChatBoostUpdated($data) : null;
	}

	public function getRemovedChatBoost(): ?ChatBoostRemoved
	{
		return ($data = $this->getData("removed_chat_boost")) && is_array($data) ? new ChatBoostRemoved($data) : null;
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
			if ($message !== null && method_exists($message, "getId") && !empty($message->getId())) return $message;
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
