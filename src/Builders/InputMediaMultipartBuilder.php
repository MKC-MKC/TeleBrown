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
		"video" => ["media", "thumbnail", "cover"],
	];

	/**
	 * Для загрузки нового файла используйте attach://<file_attach_name>
	 * и передайте файл через multipart/form-data под именем file_attach_name.
	 *
	 * @param array $media Объект InputMedia, например ["type" => "photo", "media" => "/tmp/photo.jpg"].
	 * @return array Поля multipart с объектом media и его файлами.
	 * @throws JsonException
	 * @throws RuntimeException
	 * @see https://core.telegram.org/bots/api#inputmedia
	 * @see https://core.telegram.org/bots/api#sending-files
	 */
	public static function build(array $media): array
	{
		$multipart = [];

		foreach (self::FILE_FIELDS[$media["type"] ?? ""] ?? [] as $field) {
			$path = $media[$field] ?? null;
			if (!is_string($path) || !is_file($path)) continue;

			$contents = fopen($path, "rb");
			if ($contents === false) throw new RuntimeException("Unable to open upload file");

			$name = "media_" . $field;
			$multipart[] = ["name" => $name, "contents" => $contents, "filename" => basename($path)];
			$media[$field] = "attach://" . $name;
		}

		$multipart[] = ["name" => "media", "contents" => json_encode($media, JSON_THROW_ON_ERROR)];

		return $multipart;
	}

}
