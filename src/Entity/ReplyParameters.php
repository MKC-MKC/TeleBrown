<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * ReplyParameters – Describes reply parameters for the message that is being sent.
 * @see https://core.telegram.org/bots/api#replyparameters
 */
class ReplyParameters extends Type
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	/**
	 * Optional. Identifier of the message that will be replied to in the current chat, or in the chat chat_id if it is specified
	 *
	 * @return int
	 */
	public function getMessageId(): int
	{
		return (int)($this->getData("message_id") ?? 0);
	}

	/**
	 * Optional. If the message to be replied to is from a different chat,
	 * unique identifier for the chat or username of the channel `in the format @channelusername`.
	 * Not supported for messages sent on behalf of a business account.
	 *
	 * @return int|string
	 */
	public function getChatId(): int|string
	{
		return $this->getData("chat_id") ?? 0;
	}

	/**
	 * Optional. Pass True if the message should be sent even if the specified message to be replied to is not found.
	 * Always False for replies in another chat or forum topic.
	 * Always True for messages sent on behalf of a business account.
	 *
	 * @return bool
	 */
	public function isAllowSendingWithoutReply(): bool
	{
		return ($this->getData("allow_sending_without_reply") ?? false);
	}

	/**
	 * Optional. Quoted part of the message to be replied to; 0-1024 characters after entities parsing.
	 * The quote must be an exact substring of the message to be replied to,
	 * including bold, italic, underline, strikethrough, spoiler, and custom_emoji entities.
	 * The message will fail to send if the quote isn't found in the original message.
	 *
	 * @return string
	 */
	public function getQuote(): string
	{
		return (string)($this->getData("quote") ?? "");
	}

	/**
	 * Optional. Mode for parsing entities in the quote. See formatting options for more details.
	 *
	 * @return string
	 */
	public function getQuoteParseMode(): string
	{
		return (string)($this->getData("quote_parse_mode") ?? "");
	}

	/**
	 * Optional. A JSON-serialized list of special entities that appear in the quote.
	 * It can be specified instead of quote_parse_mode.
	 *
	 * @return array
	 */
	public function getQuoteEntities(): array
	{
		return (array)$this->getData("quote_entities") ?? [];
	}

	/**
	 * Optional. Position of the quote in the original message in UTF-16 code units
	 *
	 * @return int
	 */
	public function getQuotePosition(): int
	{
		return (int)($this->getData("quote_position") ?? 0);
	}

}
