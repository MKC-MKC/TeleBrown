<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Builders;

use JsonException;
use RuntimeException;

class RichMessageMultipartBuilder
{

	private const MEDIA_TYPES = ["photo", "video", "audio", "animation", "document", "voice_note"];
	private const CONTAINER_TYPES = ["blockquote", "collage", "slideshow", "details"];

	/**
	 * Медиа в HTML и Markdown задаются полем media. Содержимое сообщения также можно задать списком blocks.
	 * Новые файлы передаются через multipart/form-data с указанием attach://<file_attach_name>.
	 *
	 * @param array $message Объект InputRichMessage.
	 * @return array Поля multipart с объектом rich_message и его файлами.
	 * @throws JsonException
	 * @throws RuntimeException
	 * @see https://core.telegram.org/bots/api#inputrichmessage
	 * @see https://core.telegram.org/bots/api#inputrichmessagemedia
	 */
	public static function build(array $message): array
	{
		$multipart = [];
		if (isset($message["media"]) && is_array($message["media"])) {
			foreach ($message["media"] as $index => &$item) {
				if (isset($item["media"]) && is_array($item["media"]) && in_array($item["media"]["type"] ?? null, self::MEDIA_TYPES, true)) {
					InputMediaMultipartBuilder::attach($item["media"], "rich_message_media_" . $index, $multipart);
				}
			}
			unset($item);
		}
		if (isset($message["blocks"]) && is_array($message["blocks"])) {
			self::attachBlocks($message["blocks"], "rich_message_blocks", $multipart);
		}
		$multipart[] = ["name" => "rich_message", "contents" => json_encode($message, JSON_THROW_ON_ERROR)];

		return $multipart;
	}

	/**
	 * Блоки медиа содержат объект InputMedia соответствующего типа.
	 * Цитаты, коллажи, слайд-шоу, раскрывающиеся блоки и элементы списка содержат вложенные blocks.
	 *
	 * @param array $blocks Список InputRichBlock.
	 * @param string $prefix Начало имени вложения, например rich_message_blocks.
	 * @param array $multipart Поля multipart для файлов.
	 * @return void
	 * @throws RuntimeException
	 * @see https://core.telegram.org/bots/api#inputrichblock
	 */
	private static function attachBlocks(array &$blocks, string $prefix, array &$multipart): void
	{
		foreach ($blocks as $index => &$block) {
			if (!is_array($block)) continue;
			$type = $block["type"] ?? null;
			$name = $prefix . "_" . $index;
			if (in_array($type, self::MEDIA_TYPES, true) && isset($block[$type]) && is_array($block[$type]) && ($block[$type]["type"] ?? null) === $type) {
				InputMediaMultipartBuilder::attach($block[$type], $name . "_" . $type, $multipart);
			} elseif (in_array($type, self::CONTAINER_TYPES, true) && isset($block["blocks"]) && is_array($block["blocks"])) {
				self::attachBlocks($block["blocks"], $name . "_blocks", $multipart);
			} elseif ($type === "list" && isset($block["items"]) && is_array($block["items"])) {
				foreach ($block["items"] as $itemIndex => &$item) {
					if (isset($item["blocks"]) && is_array($item["blocks"])) {
						self::attachBlocks($item["blocks"], $name . "_items_" . $itemIndex . "_blocks", $multipart);
					}
				}
				unset($item);
			}
		}
		unset($block);
	}

}
