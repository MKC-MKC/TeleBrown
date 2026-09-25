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

	/**
	 * Изменяем поисковые ключевые слова обычного стикера или пользовательского эмодзи.
	 * Стикер должен принадлежать набору, созданному ботом.
	 *
	 * @param string $sticker Идентификатор файла стикера.
	 * @param string[]|null $keywords От 0 до 20 поисковых ключевых слов общей длиной до 64 символов.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#setstickerkeywords
	 */
	public function setStickerKeywords(
		string     $sticker,
		array|null $keywords = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"sticker" => $sticker,
				"keywords" => $keywords,
			],
		)->isSuccess();
	}

	/**
	 * Изменяем положение маски для стикера из набора, созданного ботом.
	 *
	 * @param string $sticker Идентификатор файла стикера.
	 * @param Objects\MaskPosition|null $maskPosition Положение маски на лице. Если не указано, положение маски удаляется.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#setstickermaskposition
	 */
	public function setStickerMaskPosition(
		string                    $sticker,
		Objects\MaskPosition|null $maskPosition = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"sticker" => $sticker,
				"mask_position" => $maskPosition?->getAsArray(),
			],
		)->isSuccess();
	}

	/**
	 * Изменяем заголовок созданного набора стикеров.
	 *
	 * @param string $name Имя набора стикеров.
	 * @param string $title Заголовок набора, 1-64 символа.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#setstickersettitle
	 */
	public function setStickerSetTitle(
		string $name,
		string $title,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"name" => $name,
				"title" => $title,
			],
		)->isSuccess();
	}

	/**
	 * Изменяем миниатюру набора обычных стикеров или масок.
	 * Формат миниатюры должен совпадать с форматом стикеров набора.
	 *
	 * @param string $name Имя набора стикеров.
	 * @param int $userId Идентификатор владельца набора стикеров.
	 * @param string $format Формат миниатюры: static для WEBP или PNG, animated для TGS, video для WEBM.
	 * @param string|null $thumbnail Миниатюра: file_id, HTTP URL или путь к локальному файлу. WEBP/PNG до 128 кБ, ровно 100×100; TGS/WEBM до 32 кБ. TGS/WEBM нельзя передать по URL. Если не указана, используется первый стикер.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#setstickersetthumbnail
	 */
	public function setStickerSetThumbnail(
		string      $name,
		int         $userId,
		string      $format,
		string|null $thumbnail = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"name" => $name,
				"user_id" => $userId,
				"format" => $format,
				"thumbnail" => $thumbnail,
			],
			headers: ["Content-Type" => "multipart/form-data"],
		)->isSuccess();
	}

}
