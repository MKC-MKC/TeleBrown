<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * MessageEntity – This object represents one special entity in a text message. For example, hashtags, usernames, URLs, etc.
 * @see https://core.telegram.org/bots/api#messageentity
 */
class MessageEntity
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

	/**
	 * Type of the entity. Currently, can be “mention” (@username), “hashtag” (#hashtag or #hashtag@chatusername),
	 * “cashtag” ($USD or $USD@chatusername), “bot_command” (/start@jobs_bot),
	 * “url” (https://telegram.org), “email” (do-not-reply@telegram.org),
	 * “phone_number” (+1-212-555-0123), “bold” (bold text), “italic” (italic text),
	 * “underline” (underlined text), “strikethrough” (strikethrough text), “spoiler” (spoiler message),
	 * “blockquote” (block quotation), “expandable_blockquote” (collapsed-by-default block quotation),
	 * “code” (monowidth string), “pre” (monowidth block), “text_link” (for clickable text URLs),
	 * “text_mention” (for users without usernames), “custom_emoji” (for inline custom emoji stickers)
	 *
	 * @return string
	 */
	public function getType(): string
	{
		return (string)$this->getAsArray()["type"] ?? "";
	}

	/**
	 * Offset in UTF-16 code units to the start of the entity
	 *
	 * @return int
	 */
	public function getOffset(): int
	{
		return (int)$this->getAsArray()["offset"] ?? 0;
	}

	/**
	 * Length of the entity in UTF-16 code units
	 *
	 * @return int
	 */
	public function getLength(): int
	{
		return (int)$this->getAsArray()["length"] ?? 0;
	}

	/**
	 * Optional. For “text_link” only, URL that will be opened after user taps on the text
	 *
	 * @return string
	 */
	public function getUrl(): string
	{
		return (string)$this->getAsArray()["url"] ?? "";
	}

	/**
	 * Optional. For “text_mention” only, the mentioned user
	 *
	 * @return User
	 */
	public function getUser(): User
	{
		return new User($this->getAsArray()["user"] ?? []);
	}

	/**
	 * Optional. For “pre” only, the programming language of the entity text
	 *
	 * @return string
	 */
	public function getLanguage(): string
	{
		return (string)$this->getAsArray()["language"] ?? "";
	}

	/**
	 * Optional. For “custom_emoji” only, unique identifier of the custom emoji.
	 * Use getCustomEmojiStickers to get full information about the sticker
	 *
	 * @return string
	 */
	public function getCustomEmojiId(): string
	{
		return (string)$this->getAsArray()["custom_emoji_id"] ?? "";
	}

}
