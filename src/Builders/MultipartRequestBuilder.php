<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Builders;

use JsonException;
use RuntimeException;

class MultipartRequestBuilder
{

	private const FILE_PARAMETERS = [
		"photo", "audio", "document", "video", "animation", "voice", "video_note",
		"sticker", "thumbnail", "cover", "certificate",
	];

	/**
	 * Собираем multipart-поля, загружая локальные файлы только в файловых параметрах Telegram.
	 * Например, document с путём к файлу становится вложением, а caption с тем же путём остаётся текстом.
	 *
	 * @param array $params Параметры запроса, например ["document" => "/tmp/report.pdf", "caption" => "Отчёт"].
	 * @return array Поля multipart для HTTP-клиента.
	 * @throws JsonException
	 * @throws RuntimeException
	 * @see https://core.telegram.org/bots/api#sending-files
	 */
	public static function build(array $params): array
	{
		$multipart = [];

		foreach ($params as $name => $value) {
			if ($value === null) continue;

			if ($name === "media" && is_array($value) && isset($value["type"])) {
				array_push($multipart, ...InputMediaMultipartBuilder::build($value));
				continue;
			}

			# Загружаем только поля, предназначенные для файлов.
			if (in_array($name, self::FILE_PARAMETERS, true) && is_string($value) && is_file($value)) {
				$contents = fopen($value, "rb");
				if ($contents === false) throw new RuntimeException("Unable to open upload file");

				$multipart[] = [
					"name" => $name,
					"contents" => $contents,
					"filename" => basename($value),
				];
			} else {
				# Сохраняем структуру объектов и явные логические значения в текстовых полях.
				$multipart[] = [
					"name" => $name,
					"contents" => is_array($value) || is_object($value) || is_bool($value)
						? json_encode($value, JSON_THROW_ON_ERROR)
						: (string)$value,
				];
			}
		}

		return $multipart;
	}

}
