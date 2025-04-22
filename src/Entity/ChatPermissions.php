<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * ChatPermissions – Describes actions that a non-administrator user is allowed to take in a chat.
 * @see https://core.telegram.org/bots/api#chatpermissions
 */
class ChatPermissions extends Type
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
	 * Optional. True, if the user is allowed to send text messages, contacts, giveaways, giveaway winners, invoices, locations and venues
	 *
	 * @return bool
	 */
	public function canSendMessages(): bool
	{
		return ($this->getData("can_send_messages") ?? false);
	}

	/**
	 * Optional. True, if the user is allowed to send audios
	 *
	 * @return bool
	 */
	public function canSendAudios(): bool
	{
		return ($this->getData("can_send_audios") ?? false);
	}

	/**
	 * Optional. True, if the user is allowed to send documents
	 *
	 * @return bool
	 */
	public function canSendDocuments(): bool
	{
		return ($this->getData("can_send_documents") ?? false);
	}

	/**
	 * Optional. True, if the user is allowed to send photos
	 *
	 * @return bool
	 */
	public function canSendPhotos(): bool
	{
		return ($this->getData("can_send_photos") ?? false);
	}

	/**
	 * Optional. True, if the user is allowed to send videos
	 *
	 * @return bool
	 */
	public function canSendVideos(): bool
	{
		return ($this->getData("can_send_videos") ?? false);
	}

	/**
	 * Optional. True, if the user is allowed to send video notes
	 *
	 * @return bool
	 */
	public function canSendVideoNotes(): bool
	{
		return ($this->getData("can_send_video_notes") ?? false);
	}

	/**
	 * Optional. True, if the user is allowed to send voice notes
	 *
	 * @return bool
	 */
	public function canSendVoiceNotes(): bool
	{
		return ($this->getData("can_send_voice_notes") ?? false);
	}

	/**
	 * Optional. True, if the user is allowed to send polls
	 *
	 * @return bool
	 */
	public function canSendPolls(): bool
	{
		return ($this->getData("can_send_polls") ?? false);
	}

	/**
	 * Optional. True, if the user is allowed to send animations, games, stickers and use inline bots
	 *
	 * @return bool
	 */
	public function canSendOtherMessages(): bool
	{
		return ($this->getData("can_send_other_messages") ?? false);
	}

	/**
	 * Optional. True, if the user is allowed to add web page previews to their messages
	 *
	 * @return bool
	 */
	public function canAddWebPagePreviews(): bool
	{
		return ($this->getData("can_add_web_page_previews") ?? false);
	}

	/**
	 * Optional. True, if the user is allowed to change the chat title, photo and other settings. Ignored in public supergroups
	 *
	 * @return bool
	 */
	public function canChangeInfo(): bool
	{
		return ($this->getData("can_change_info") ?? false);
	}

	/**
	 * Optional. True, if the user is allowed to invite new users to the chat
	 *
	 * @return bool
	 */
	public function canInviteUsers(): bool
	{
		return ($this->getData("can_invite_users") ?? false);
	}

	/**
	 * Optional. True, if the user is allowed to pin messages. Ignored in public supergroups
	 *
	 * @return bool
	 */
	public function canPinMessages(): bool
	{
		return ($this->getData("can_pin_messages") ?? false);
	}

	/**
	 * Optional. True, if the user is allowed to create forum topics. If omitted defaults to the value of can_pin_messages
	 *
	 * @return bool
	 */
	public function canManageTopics(): bool
	{
		return ($this->getData("can_manage_topics") ?? false);
	}

}
