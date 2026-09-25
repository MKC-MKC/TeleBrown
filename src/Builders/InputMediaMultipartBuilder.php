<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Builders;

use JsonException;
use RuntimeException;

class InputMediaMultipartBuilder
{

	private const FILE_FIELDS = [
		"animation" => ["media", "thumbnail"],
		"audio" => ["media", "thumbnail"],
		"document" => ["media", "thumbnail"],
		"live_photo" => ["media", "photo"],
		"photo" => ["media"],
		"sticker" => ["media"],
		"video" => ["media", "thumbnail", "cover"],
	];

	/**
	 * Для загрузки нового файла используйте attach://<file_attach_name>
	 * и передайте файл через multipart/form-data под именем file_attach_name.
	 *
	 * @param array $media Объект InputMedia, например ["type" => "photo", "media" => "/tmp/photo.jpg"].
	 * @param string $name Имя параметра: media, explanation_media, options или photo.
	 * @return array Поля multipart с объектом media и его файлами.
	 * @throws JsonException
	 * @throws RuntimeException
	 * @see https://core.telegram.org/bots/api#inputmedia
	 * @see https://core.telegram.org/bots/api#sending-files
	 * @see https://core.telegram.org/bots/api#inputprofilephoto
	 * @see https://core.telegram.org/bots/api#inputpolloption
	 */
	public static function build(array $media, string $name = "media"): array
	{
		$multipart = [];

		if ($name === "sticker") {
			MultipartAttachmentBuilder::attach($media, ["sticker"], $name, $multipart);
		} elseif ($name === "stickers") {
			foreach ($media as $index => &$sticker) {
				if (is_array($sticker)) MultipartAttachmentBuilder::attach($sticker, ["sticker"], $name . "_" . $index, $multipart);
			}
			unset($sticker);
		} elseif ($name === "options") {
			foreach ($media as $index => &$option) {
				if (is_array($option) && isset($option["media"]) && is_array($option["media"])) {
					self::attach($option["media"], $name . "_" . $index . "_media", $multipart);
				}
			}
			unset($option);
		} elseif ($name === "media" && array_is_list($media)) {
			foreach ($media as $index => &$item) {
				if (is_array($item)) self::attach($item, $name . "_" . $index, $multipart);
			}
			unset($item);
		} else {
			self::attach($media, $name, $multipart, $name === "photo");
		}

		$multipart[] = ["name" => $name, "contents" => json_encode($media, JSON_THROW_ON_ERROR)];

		return $multipart;
	}

	/**
	 * Новые файлы передаются через multipart/form-data, а в объекте указываются как attach://<file_attach_name>.
	 *
	 * @param array $media Объект с файловыми полями, например ["type" => "photo", "media" => "/tmp/photo.jpg"].
	 * @param string $prefix Начало имени вложения, например media_0.
	 * @param array $multipart Поля multipart для файлов.
	 * @param bool $profilePhoto true для объекта InputProfilePhoto.
	 * @return void
	 * @throws RuntimeException
	 * @see https://core.telegram.org/bots/api#sending-files
	 */
	private static function attach(array &$media, string $prefix, array &$multipart, bool $profilePhoto = false): void
	{
		$fields = $profilePhoto
			? (["static" => ["photo"], "animated" => ["animation"]][$media["type"] ?? ""] ?? [])
			: (self::FILE_FIELDS[$media["type"] ?? ""] ?? []);

		MultipartAttachmentBuilder::attach($media, $fields, $prefix, $multipart);
	}

}
