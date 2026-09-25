<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class BusinessMessagesDeleted extends ResponseWrapper
{

	/**
	 * Уникальный идентификатор бизнес-подключения.
	 *
	 * @return string
	 * @see https://core.telegram.org/bots/api#businessmessagesdeleted
	 */
	public function getBusinessConnectionId(): string
	{
		return (string)$this->getData("business_connection_id");
	}

	/**
	 * Чат бизнес-аккаунта. Бот может не иметь доступа к чату или соответствующему пользователю.
	 *
	 * @return Chat
	 * @see https://core.telegram.org/bots/api#businessmessagesdeleted
	 */
	public function getChat(): Chat
	{
		$data = $this->getData("chat");
		return new Chat($data);
	}

	/**
	 * Идентификаторы удалённых сообщений в чате бизнес-аккаунта.
	 *
	 * @return array
	 * @see https://core.telegram.org/bots/api#businessmessagesdeleted
	 */
	public function getMessageIds(): array
	{
		return (array)$this->getData("message_ids", []);
	}

}
