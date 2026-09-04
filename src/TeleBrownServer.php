<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown;

use GuzzleHttp\Client;
use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Throwable;

class TeleBrownServer extends TeleBrownServerAbstract
{

	/**
	 * Метод отправки POST запроса на сервер API.
	 *
	 * @param string $method
	 * @param array $params
	 * @param array $headers
	 * @return Response
	 * @throws TelegramMainException
	 */
	public function sendRequest(string $method, array $params = [], array $headers = ["Content-Type" => "application/json"]): object
	{
		# Сериализация пустых параметров.
		$isMultipart = isset($headers["Content-Type"]) && strtolower($headers["Content-Type"]) === "multipart/form-data";
		if ($params) {
			$params = array_filter($params, static fn($value) => !is_null($value));
		}

		if (!$isMultipart && $params) {
			$params = array_map(static fn($value) => is_object($value) ? json_encode($value) : $value, $params);
		}

		if ($isMultipart) unset($headers["Content-Type"]);

		# Формируем URL.
		$url = $this->buildRequestUrl($method);

		# Формируем заголовки.
		$options = [];
		$options["headers"] = $headers;

		# Тайм-аут соединения.
		if (!is_null($this->getConnectTimeout())) $options["connect_timeout"] = $options["timeout"] = $this->getConnectTimeout();

		if (isset($params["timeout"]) && is_numeric($params["timeout"])) {
			$options["timeout"] = (int)$params["timeout"] + 10;
		}

		# Формируем параметры прокси.
		if (!empty($this->proxy)) $options["proxy"] = $this->proxy;

		# Отправляем запрос.
		try {
			$client = $this->createClient($options);

			if ($isMultipart) {
				$multipart = [];

				foreach ($params as $name => $value) {
					if (is_string($value) && is_file($value)) {
						$multipart[] = [
							"name" => $name,
							"contents" => fopen($value, "rb"),
							"filename" => basename($value),
						];
					} else {
						$multipart[] = [
							"name" => $name,
							"contents" => is_array($value) || is_object($value) ? json_encode($value) : (string)$value,
						];
					}
				}

				$response = $client->post($url, ["multipart" => $multipart]);
			} else {
				$response = $client->post($url, ["json" => $params]);
			}

			$body = $response->getBody()->getContents();
			if (self::$debug) error_log(PHP_EOL . ">>>>>>>>>>" . PHP_EOL . var_export($params, true));
		} catch (Throwable $e) {
			throw new TelegramMainException(message: $e->getMessage(), code: $e->getCode(), previous: $e);
		}

		# Валидация ответа.
		$validResponse = self::validate($body, true);
		if (!is_array($validResponse) || !($validResponse["ok"] ?? false)) {
			throw new TelegramMainException(message: $validResponse["description"] ?? "Unknown error", code: $validResponse["error_code"] ?? 0);
		}

		return Response::fromResponse($validResponse);
	}

	/**
	 * Метод загружает файл Telegram в указанный путь.
	 *
	 * @param string $fileId
	 * @param string $destination
	 * @param bool $overwrite
	 * @return Objects\File
	 * @throws TelegramMainException
	 */
	public function downloadFile(string $fileId, string $destination, bool $overwrite = false): Objects\File
	{
		if (!$overwrite && (file_exists($destination) || is_link($destination))) {
			throw new TelegramMainException("Destination file already exists");
		}

		$temporaryDestination = null;

		try {
			# Защищаем существующий файл от повреждения при незавершённой загрузке.
			$directory = dirname($destination);
			if (!is_dir($directory) || !is_writable($directory)) throw new TelegramMainException("Download directory is not writable");
			$temporaryDestination = tempnam($directory, ".telebrown-");
			if ($temporaryDestination === false) throw new TelegramMainException("Unable to create a temporary file");

			# Получаем актуальный путь перед загрузкой файла.
			$file = $this->getFile($fileId);
			$filePath = $file->getFilePath();
			if ($filePath === null || $filePath === "") throw new TelegramMainException("Telegram API did not return a file path");

			# Применяем настройки соединения сервера к загрузке файла.
			$options = [];
			if (!is_null($this->getConnectTimeout())) $options["connect_timeout"] = $options["timeout"] = $this->getConnectTimeout();
			if (!empty($this->proxy)) $options["proxy"] = $this->proxy;

			$this->createClient($options)->get(
				$this->buildFileUrl($filePath),
				["sink" => $temporaryDestination],
			);

			# Атомарно сохраняем результат согласно политике перезаписи.
			$isSaved = $overwrite
				? rename($temporaryDestination, $destination)
				: link($temporaryDestination, $destination);
			if (!$isSaved) throw new TelegramMainException("Unable to save the downloaded file");
			if (!$overwrite) unlink($temporaryDestination);
			$temporaryDestination = null;
		} catch (Throwable $e) {
			if ($temporaryDestination !== null && is_file($temporaryDestination)) unlink($temporaryDestination);

			throw new TelegramMainException(message: "Unable to download Telegram file", code: (int)$e->getCode());
		}

		return $file;
	}

	/**
	 * Метод создаёт HTTP-клиент с указанными настройками.
	 *
	 * @param array $options
	 * @return Client
	 */
	protected function createClient(array $options): Client
	{
		return new Client($options);
	}

	/**
	 * Сборка и нормализация request url.
	 * @param string $method
	 * @return string
	 */
	protected function buildRequestUrl(string $method): string
	{
		$url = rtrim($this->getUrl(), "/");
		$segments = explode("/", $url);
		$lastSegment = end($segments);

		if (is_string($lastSegment) && count($segments) > 3 && str_starts_with($lastSegment, "bot")) {
			# Срезаем переданный в URL (bot+токен).
			array_pop($segments);

			# Убираем file-префикс, если передан.
			if (end($segments) === "file") array_pop($segments);
			$url = implode("/", $segments);
		}

		return $url . "/bot" . $this->getToken() . "/" . $method;
	}

	/**
	 * Метод собирает и нормализует URL для загрузки файла.
	 *
	 * @param string $filePath
	 * @return string
	 */
	protected function buildFileUrl(string $filePath): string
	{
		$url = rtrim($this->getUrl(), "/");
		$segments = explode("/", $url);
		$lastSegment = end($segments);

		# Убираем контрактные сегменты из переданного базового URL.
		if (is_string($lastSegment) && count($segments) > 3 && str_starts_with($lastSegment, "bot")) {
			array_pop($segments);
			$lastSegment = end($segments);
		}

		if ($lastSegment === "file") array_pop($segments);
		$url = implode("/", $segments);

		# Экранируем компоненты пути без потери вложенности каталогов Telegram.
		$filePath = implode("/", array_map("rawurlencode", explode("/", ltrim($filePath, "/"))));

		return $url . "/file/bot" . $this->getToken() . "/" . $filePath;
	}

	/**
	 * Метод валидации ответа JSON.
	 *
	 * @param mixed $json
	 * @param bool|null $asArray
	 * @param int $depth
	 * @param int $flags
	 * @return object|array
	 * @throws TelegramMainException
	 */
	public static function validate(mixed $json, ?bool $asArray = null, int $depth = 512, int $flags = 0): object|array
	{
		if (!is_string($json)) throw new TelegramMainException("Invalid response from the server: \$json is not a string");
		$result = json_decode($json, $asArray, $depth, $flags);
		if (self::$debug) error_log(PHP_EOL . "<<<<<<<<<<" . PHP_EOL . var_export($result, true));
		if (json_last_error() !== JSON_ERROR_NONE) throw new TelegramMainException(json_last_error_msg(), json_last_error());
		return $result;
	}

}
