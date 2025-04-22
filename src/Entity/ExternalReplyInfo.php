<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * TODO: ExternalReplyInfo – This object contains information about a message that is being replied to, which may come from another chat or forum topic.
 * @see https://core.telegram.org/bots/api#externalreplyinfo
 */
class ExternalReplyInfo extends Type
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
	 * Origin of the message replied to by the given message
	 *
	 * @return MessageOrigin|null
	 */
	public function getOrigin(): ?MessageOrigin
	{
		return new MessageOrigin();
	}

	/**
	 * Optional. Chat the original message belongs to. Available only if the chat is a supergroup or a channel.
	 *
	 * @return Chat|null
	 */
	public function getChat(): ?Chat
	{
		return new Chat($this->response) ?? null;
	}

	/**
	 * Optional. Unique message identifier inside the original chat. Available only if the original chat is a supergroup or a channel.
	 *
	 * @return int
	 */
	public function getMessageId(): int
	{
		return (int)$this->getData("message_id") ?? 0;
	}

	/**
	 * Optional. Options used for link preview generation for the original message, if it is a text message
	 *
	 * @return LinkPreviewOptions|null
	 */
	public function getLinksPreviewOptions(): ?LinkPreviewOptions
	{
		return null;
	}

	public function getAnimation()
	{

	}

	public function getAudio()
	{

	}

	public function getDocument()
	{

	}

	public function getPhoto()
	{

	}

	public function getSticker()
	{

	}

	public function getStory()
	{

	}

	public function getVideo()
	{

	}

	public function getVideoNote()
	{

	}

	public function getVoice()
	{

	}

	public function hasMediaSpoiler()
	{

	}

	/**
	 * Optional. Message is a shared contact, information about the contact
	 *
	 * @return Contact|null
	 */
	public function getContact(): ?Contact
	{
		return new Contact($this->response) ?? null;
	}

	public function getDice()
	{

	}

	public function getGame()
	{

	}

	public function getGiveaway()
	{

	}

	public function getInvoice()
	{

	}

	/**
	 * Optional. Message is a shared location, information about the location
	 *
	 * @return Location|null
	 */
	public function getLocation(): ?Location
	{
		return new Location($this->response) ?? null;
	}

	public function getPool()
	{

	}

	public function getVenue()
	{

	}

}
