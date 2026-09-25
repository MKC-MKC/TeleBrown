<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

class Story extends ResponseWrapper
{

	/**
	 * Чат, опубликовавший историю.
	 *
	 * @return Chat
	 * @see https://core.telegram.org/bots/api#story
	 */
	public function getChat(): Chat
	{
		$data = $this->getData("chat");
		return new Chat($data);
	}

	/**
	 * Уникальный идентификатор истории в чате.
	 *
	 * @return int
	 * @see https://core.telegram.org/bots/api#story
	 */
	public function getId(): int
	{
		return (int)$this->getData("id");
	}

}
