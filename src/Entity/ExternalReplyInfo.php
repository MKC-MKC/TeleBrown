<?php /** @noinspection PhpUnused */

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * TODO: ExternalReplyInfo – This object contains information about a message that is being replied to, which may come from another chat or forum topic.
 * @see https://core.telegram.org/bots/api#externalreplyinfo
 */
class ExternalReplyInfo extends ResponseWrapper
{

	/**
	 * Origin of the message replied to by the given message
	 *
	 * @return MessageOrigin
	 */
	public function getOrigin(): MessageOrigin
	{
		$data = (array)$this->getData("origin", []);
		return new MessageOrigin($data);
	}

	/**
	 * Optional. Chat the original message belongs to. Available only if the chat is a supergroup or a channel.
	 *
	 * @return Chat
	 */
	public function getChat(): Chat
	{
		$data = (array)$this->getData("chat", []);
		return new Chat($data);
	}

	/**
	 * Optional. Unique message identifier inside the original chat. Available only if the original chat is a supergroup or a channel.
	 *
	 * @return int
	 */
	public function getMessageId(): int
	{
		return (int)$this->getData("message_id");
	}

	/**
	 * Optional. Options used for link preview generation for the original message, if it is a text message
	 *
	 * @return LinkPreviewOptions
	 */
	public function getLinksPreviewOptions(): LinkPreviewOptions
	{
		$data = (array)$this->getData("link_preview_options", []);
		return new LinkPreviewOptions($data);
	}

	/** @deprecated */
	public function getAnimation()
	{

	}

	/** @deprecated */
	public function getAudio()
	{

	}

	/** @deprecated */
	public function getDocument()
	{

	}

	/** @deprecated */
	public function getPhoto()
	{

	}

	/** @deprecated */
	public function getSticker()
	{

	}

	/** @deprecated */
	public function getStory()
	{

	}

	/** @deprecated */
	public function getVideo()
	{

	}

	/** @deprecated */
	public function getVideoNote()
	{

	}

	/** @deprecated */
	public function getVoice()
	{

	}

	/** @deprecated */
	public function hasMediaSpoiler()
	{

	}

	/**
	 * Optional. Message is a shared contact, information about the contact
	 *
	 * @return Contact
	 */
	public function getContact(): Contact
	{
		$data = (array)$this->getData("contact", []);
		return new Contact($data);
	}

	/** @deprecated */
	public function getDice()
	{

	}

	/** @deprecated */
	public function getGame()
	{

	}

	/** @deprecated */
	public function getGiveaway()
	{

	}

	/** @deprecated */
	public function getInvoice()
	{

	}

	/**
	 * Optional. Message is a shared location, information about the location
	 *
	 * @return Location
	 */
	public function getLocation(): Location
	{
		$data = (array)$this->getData("location", []);
		return new Location($data);
	}

	/** @deprecated */
	public function getPool()
	{

	}

	/** @deprecated */
	public function getVenue()
	{

	}

}
