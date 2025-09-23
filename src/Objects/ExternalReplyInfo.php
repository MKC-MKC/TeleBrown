<?php /** @noinspection PhpUnused */

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * ExternalReplyInfo – This object contains information about a message that is being replied to,
 * which may come from another chat or forum topic.
 * @see https://core.telegram.org/bots/api#externalreplyinfo
 */
class ExternalReplyInfo extends ResponseWrapper
{

	/**
	 * Origin of the message replied to by the given message
	 * @return MessageOrigin
	 */
	public function getOrigin(): object
	{
		$data = (array)$this->getData("origin", []);
		return new MessageOrigin($data);
	}

	/**
	 * Optional. Chat the original message belongs to. Available only if the chat is a supergroup or a channel.
	 * @return Chat
	 */
	public function getChat(): object
	{
		$data = (array)$this->getData("chat", []);
		return new Chat($data);
	}

	/**
	 * Optional. Unique message identifier inside the original chat. Available only if the original chat is a supergroup or a channel.
	 * @return int
	 */
	public function getMessageId(): int
	{
		return (int)$this->getData("message_id");
	}

	/**
	 * Optional. Options used for link preview generation for the original message, if it is a text message
	 * @return LinkPreviewOptions
	 */
	public function getLinksPreviewOptions(): object
	{
		$data = (array)$this->getData("link_preview_options", []);
		return new LinkPreviewOptions($data);
	}

	/**
	 * Optional. Message is an animation, information about the animation
	 * @return Animation
	 */
	public function getAnimation(): object
	{
		$data = (array)$this->getData("animation", []);
		return new Animation($data);
	}

	/**
	 * Optional. Message is an audio file, information about the file
	 * @return Audio
	 */
	public function getAudio(): object
	{
		$data = (array)$this->getData("audio", []);
		return new Audio($data);
	}

	/**
	 * Optional. Message is a general file, information about the file
	 * @return Document
	 */
	public function getDocument(): object
	{
		$data = (array)$this->getData("document", []);
		return new Document($data);
	}

	/**
	 * Optional. Message contains paid media; information about the paid media
	 * @return PaidMediaInfo
	 */
	public function getPaidMedia(): object
	{
		$data = (array)$this->getData("paid_media", []);
		return new PaidMediaInfo($data);
	}

	/**
	 * Optional. Message is a photo, available sizes of the photo
	 * @return PhotoSize[]
	 */
	public function getPhoto(): array
	{
		$data = $this->getData("photo");
		return array_map(fn(array $item): PhotoSize => new PhotoSize($item), $data);
	}

	/**
	 * Optional. Message is a sticker, information about the sticker
	 * @return Sticker
	 */
	public function getSticker(): object
	{
		$data = (array)$this->getData("sticker", []);
		return new Sticker($data);
	}

	/**
	 * Optional. Message is a forwarded story
	 * @return Story
	 */
	public function getStory(): object
	{
		$data = (array)$this->getData("story", []);
		return new Story($data);
	}

	/**
	 * Optional. Message is a video, information about the video
	 * @return Video
	 */
	public function getVideo(): object
	{
		$data = (array)$this->getData("video", []);
		return new Video($data);
	}

	/**
	 * Optional. Message is a video note, information about the video message
	 * @return VideoNote
	 */
	public function getVideoNote(): object
	{
		$data = (array)$this->getData("video_note", []);
		return new VideoNote($data);
	}

	/**
	 * Optional. Message is a voice message, information about the file
	 * @return Voice
	 */
	public function getVoice(): object
	{
		$data = (array)$this->getData("voice", []);
		return new Voice($data);
	}

	/**
	 * Optional. True, if the message media is covered by a spoiler animation
	 * @return bool
	 */
	public function hasMediaSpoiler(): bool
	{
		return (bool)$this->getData("has_media_spoiler");
	}

	/**
	 * Optional. Message is a shared contact, information about the contact
	 * @return Contact
	 */
	public function getContact(): object
	{
		$data = (array)$this->getData("contact", []);
		return new Contact($data);
	}

	/**
	 * Optional. Message is a dice with random value
	 * @return Dice
	 * @noinspection GrazieInspection
	 */
	public function getDice(): object
	{
		$data = (array)$this->getData("dice", []);
		return new Dice($data);
	}

	/**
	 * Optional. Message is a game, information about the game.
	 * @return Game
	 */
	public function getGame(): object
	{
		$data = (array)$this->getData("game", []);
		return new Game($data);
	}

	/**
	 * Optional. Message is a scheduled giveaway, information about the giveaway
	 * @return Giveaway
	 */
	public function getGiveaway(): object
	{
		$data = (array)$this->getData("giveaway", []);
		return new Giveaway($data);
	}

	/**
	 * Optional. A giveaway with public winners was completed
	 * @return GiveawayWinners
	 */
	public function getGiveawayWinners(): object
	{
		$data = (array)$this->getData("giveaway_winners", []);
		return new GiveawayWinners($data);
	}

	/**
	 * Optional. Message is an invoice for a payment, information about the invoice.
	 * @return Invoice
	 */
	public function getInvoice(): object
	{
		$data = (array)$this->getData("invoice", []);
		return new Invoice($data);
	}

	/**
	 * Optional. Message is a shared location, information about the location
	 * @return Location
	 */
	public function getLocation(): object
	{
		$data = (array)$this->getData("location", []);
		return new Location($data);
	}

	/**
	 * Optional. Message is a native poll, information about the poll
	 * @return Poll
	 */
	public function getPool(): object
	{
		$data = (array)$this->getData("poll", []);
		return new Poll($data);
	}

	/**
	 * Optional. Message is a venue, information about the venue
	 * @return Venue
	 */
	public function getVenue(): object
	{
		$data = (array)$this->getData("venue", []);
		return new Venue($data);
	}

}
