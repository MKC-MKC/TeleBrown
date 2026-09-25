<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects;

trait StickerSets
{

	/**
	 * Получаем набор стикеров.
	 *
	 * @param string $name Имя набора стикеров.
	 * @return Objects\StickerSet
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#getstickerset
	 */
	public function getStickerSet(
		string $name,
	): Objects\StickerSet
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"name" => $name,
			],
		);

		return new Objects\StickerSet($response->getData());
	}

}
