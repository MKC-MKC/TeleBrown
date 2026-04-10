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
		if (!$isMultipart && $params) {
			$params = array_filter($params, static fn($value) => !is_null($value));
			$params = array_map(static function ($value) {
				return (is_array($value) || is_object($value)) ? json_encode($value) : $value;
			}, $params);
		}

		# Формируем URL.
		$url = $this->buildRequestUrl($method);

		# Формируем заголовки.
		$options = [];
		$options["headers"] = $headers;

		# Формируем параметры прокси.
		if (!empty($this->proxy)) $options["proxy"] = $this->proxy;

		# Отправляем запрос.
		try {
			$client = new Client($options);

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
