<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Builders;

use RuntimeException;

class MultipartAttachmentBuilder
{

	/**
	 * Передаём новый файл через multipart/form-data под именем file_attach_name.
	 * В файловом поле указываем attach://<file_attach_name>.
	 *
	 * @param array $media Объект с файловыми полями.
	 * @param array $fields Имена файловых полей, например ["sticker"].
	 * @param string $prefix Начало имени вложения, например stickers_0.
	 * @param array $multipart Поля multipart для файлов.
	 * @return void
	 * @throws RuntimeException
	 * @see https://core.telegram.org/bots/api#sending-files
	 */
	public static function attach(array &$media, array $fields, string $prefix, array &$multipart): void
	{
		foreach ($fields as $field) {
			$path = $media[$field] ?? null;
			if (!is_string($path) || !is_file($path)) continue;

			$contents = fopen($path, "rb");
			if ($contents === false) throw new RuntimeException("Unable to open upload file");

			$name = $prefix . "_" . $field;
			$multipart[] = ["name" => $name, "contents" => $contents, "filename" => basename($path)];
			$media[$field] = "attach://" . $name;
		}
	}

}
