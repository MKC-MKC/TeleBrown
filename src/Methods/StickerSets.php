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

	/**
	 * Создаём принадлежащий пользователю набор стикеров. Бот сможет редактировать созданный набор.
	 *
	 * @param int $userId Идентификатор владельца набора стикеров.
	 * @param string $name Короткое имя набора, 1-64 символа: английские буквы, цифры и подчёркивания. Начинается с буквы, без двойных подчёркиваний, оканчивается на _by_<bot_username>.
	 * @param string $title Заголовок набора, 1-64 символа.
	 * @param Objects\InputSticker[]|array $stickers От 1 до 50 начальных стикеров набора.
	 * @param string|null $stickerType Тип стикеров: regular, mask или custom_emoji. По умолчанию regular.
	 * @param bool|null $needsRepainting True, если эмодзи должны перекрашиваться в цвет текста, акцентный цвет статуса, белый цвет на фотографиях чатов или другой цвет по контексту; только для custom_emoji.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#createnewstickerset
	 */
	public function createNewStickerSet(
		int         $userId,
		string      $name,
		string      $title,
		array       $stickers,
		string|null $stickerType = null,
		bool|null   $needsRepainting = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"user_id" => $userId,
				"name" => $name,
				"title" => $title,
				"stickers" => $stickers,
				"sticker_type" => $stickerType,
				"needs_repainting" => $needsRepainting,
			],
			headers: ["Content-Type" => "multipart/form-data"],
		)->isSuccess();
	}

	/**
	 * Добавляем стикер в созданный ботом набор.
	 * Наборы эмодзи могут содержать до 200 стикеров, остальные наборы до 120.
	 *
	 * @param int $userId Идентификатор владельца набора стикеров.
	 * @param string $name Имя набора стикеров.
	 * @param Objects\InputSticker $sticker Добавляемый стикер. Если точно такой же стикер уже есть в наборе, набор не изменяется.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#addstickertoset
	 */
	public function addStickerToSet(
		int                  $userId,
		string               $name,
		Objects\InputSticker $sticker,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"user_id" => $userId,
				"name" => $name,
				"sticker" => $sticker->getAsArray(),
			],
			headers: ["Content-Type" => "multipart/form-data"],
		)->isSuccess();
	}

	/**
	 * Перемещаем стикер в созданном ботом наборе на указанную позицию.
	 *
	 * @param string $sticker Идентификатор файла стикера.
	 * @param int $position Новая позиция стикера в наборе, начиная с нуля.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#setstickerpositioninset
	 */
	public function setStickerPositionInSet(
		string $sticker,
		int    $position,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"sticker" => $sticker,
				"position" => $position,
			],
		)->isSuccess();
	}

	/**
	 * Удаляем стикер из созданного ботом набора.
	 *
	 * @param string $sticker Идентификатор файла стикера.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#deletestickerfromset
	 */
	public function deleteStickerFromSet(
		string $sticker,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"sticker" => $sticker,
			],
		)->isSuccess();
	}

	/**
	 * Заменяем существующий стикер в наборе новым.
	 * Равнозначно последовательному вызову deleteStickerFromSet, addStickerToSet и setStickerPositionInSet.
	 *
	 * @param int $userId Идентификатор владельца набора стикеров.
	 * @param string $name Имя набора стикеров.
	 * @param string $oldSticker Идентификатор файла заменяемого стикера.
	 * @param Objects\InputSticker $sticker Добавляемый стикер. Если точно такой же стикер уже есть в наборе, набор не изменяется.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#replacestickerinset
	 */
	public function replaceStickerInSet(
		int                  $userId,
		string               $name,
		string               $oldSticker,
		Objects\InputSticker $sticker,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"user_id" => $userId,
				"name" => $name,
				"old_sticker" => $oldSticker,
				"sticker" => $sticker->getAsArray(),
			],
			headers: ["Content-Type" => "multipart/form-data"],
		)->isSuccess();
	}

	/**
	 * Изменяем список эмодзи обычного стикера или пользовательского эмодзи.
	 * Стикер должен принадлежать набору, созданному ботом.
	 *
	 * @param string $sticker Идентификатор файла стикера.
	 * @param string[] $emojiList От 1 до 20 эмодзи, связанных со стикером.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#setstickeremojilist
	 */
	public function setStickerEmojiList(
		string $sticker,
		array  $emojiList,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"sticker" => $sticker,
				"emoji_list" => $emojiList,
			],
		)->isSuccess();
	}

}
