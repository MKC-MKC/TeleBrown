<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects\ChatMember;

use Haikiri\TeleBrown\Objects\ChatMember;
use Haikiri\TeleBrown\Objects\User;

/**
 * ChatMemberRestricted – Represents a chat member that is under certain restrictions in the chat. Supergroups only.
 * @see https://core.telegram.org/bots/api#chatmemberrestricted
 */
class ChatMemberRestricted extends ChatMember
{
	protected static string $status = "restricted";

	public static function getStatus(): string
	{
		return self::$status;
	}

	public function getUser(): User
	{
		$data = (array)$this->getData("user", []);
		return new User($data);
	}

	public function getUntilDate(): int
	{
		return (int)$this->getData("until_date", 0);
	}

	/**
	 * Необязательно. Метка участника.
	 *
	 * @return string|null
	 * @see https://core.telegram.org/bots/api#chatmemberrestricted
	 */
	public function getTag(): string|null
	{
		return $this->getData("tag");
	}

	/**
	 * True, если пользователь состоит в чате на момент запроса.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#chatmemberrestricted
	 */
	public function isMember(): bool
	{
		return (bool)$this->getData("is_member");
	}

	/**
	 * True, если пользователь может отправлять текст, rich-сообщения, контакты, розыгрыши, счета и геопозиции.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#chatmemberrestricted
	 */
	public function canSendMessages(): bool
	{
		return (bool)$this->getData("can_send_messages");
	}

	/**
	 * True, если пользователь может отправлять аудио.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#chatmemberrestricted
	 */
	public function canSendAudios(): bool
	{
		return (bool)$this->getData("can_send_audios");
	}

	/**
	 * True, если пользователь может отправлять документы.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#chatmemberrestricted
	 */
	public function canSendDocuments(): bool
	{
		return (bool)$this->getData("can_send_documents");
	}

	/**
	 * True, если пользователь может отправлять фотографии.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#chatmemberrestricted
	 */
	public function canSendPhotos(): bool
	{
		return (bool)$this->getData("can_send_photos");
	}

	/**
	 * True, если пользователь может отправлять видео.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#chatmemberrestricted
	 */
	public function canSendVideos(): bool
	{
		return (bool)$this->getData("can_send_videos");
	}

	/**
	 * True, если пользователь может отправлять видеосообщения.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#chatmemberrestricted
	 */
	public function canSendVideoNotes(): bool
	{
		return (bool)$this->getData("can_send_video_notes");
	}

	/**
	 * True, если пользователь может отправлять голосовые сообщения.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#chatmemberrestricted
	 */
	public function canSendVoiceNotes(): bool
	{
		return (bool)$this->getData("can_send_voice_notes");
	}

	/**
	 * True, если пользователь может отправлять опросы и списки задач.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#chatmemberrestricted
	 */
	public function canSendPolls(): bool
	{
		return (bool)$this->getData("can_send_polls");
	}

	/**
	 * True, если пользователь может отправлять анимации, игры, стикеры и использовать inline-ботов.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#chatmemberrestricted
	 */
	public function canSendOtherMessages(): bool
	{
		return (bool)$this->getData("can_send_other_messages");
	}

	/**
	 * True, если пользователь может добавлять предпросмотр веб-страниц.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#chatmemberrestricted
	 */
	public function canAddWebPagePreviews(): bool
	{
		return (bool)$this->getData("can_add_web_page_previews");
	}

	/**
	 * True, если пользователь может оставлять реакции на сообщения.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#chatmemberrestricted
	 */
	public function canReactToMessages(): bool
	{
		return (bool)$this->getData("can_react_to_messages");
	}

	/**
	 * True, если пользователь может менять свою метку.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#chatmemberrestricted
	 */
	public function canEditTag(): bool
	{
		return (bool)$this->getData("can_edit_tag");
	}

	/**
	 * True, если пользователь может менять название, фотографию и другие настройки чата.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#chatmemberrestricted
	 */
	public function canChangeInfo(): bool
	{
		return (bool)$this->getData("can_change_info");
	}

	/**
	 * True, если пользователь может приглашать новых участников.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#chatmemberrestricted
	 */
	public function canInviteUsers(): bool
	{
		return (bool)$this->getData("can_invite_users");
	}

	/**
	 * True, если пользователь может закреплять сообщения.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#chatmemberrestricted
	 */
	public function canPinMessages(): bool
	{
		return (bool)$this->getData("can_pin_messages");
	}

	/**
	 * True, если пользователь может создавать темы форума.
	 *
	 * @return bool
	 * @see https://core.telegram.org/bots/api#chatmemberrestricted
	 */
	public function canManageTopics(): bool
	{
		return (bool)$this->getData("can_manage_topics");
	}

}
