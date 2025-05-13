<?php

namespace Haikiri\TeleBrown;

class TeleBrownServer extends TeleBrownServerAbstract
{

	#	Proxy SOCKS:
	public bool $isProxy = false;    # true - enable proxy ; false - disable proxy ;
	public int $proxy_opt = CURLOPT_PROXYUSERPWD;
	public int $proxy_type = CURLPROXY_SOCKS5;
	public int $proxy_port = 8080;
	public string $proxy_addr = "";
	public string $proxy_user = "";
	public string $proxy_pass = "";

	/**
	 * Метод отправки POST запроса на сервер API.
	 *
	 * @param string $method
	 * @param array $params
	 * @param array $headers
	 * @return mixed
	 * @throws TelegramMainException
	 */
	public function sendRequest(string $method, array $params = [], array $headers = ["Content-Type: application/json"]): mixed
	{
		# Сериализация пустых параметров.
		if ($params) {
			$params = array_filter($params, fn($value) => !is_null($value));
			$params = array_map(function ($value) {
				return (is_array($value) || is_object($value)) ? json_encode($value) : $value;
			}, $params);
		}

		# Формируем URL.
		$url = rtrim($this->getUrl(), "/") . $this->getToken();
		$ch = curl_init("$url/$method");

		# Формируем заголовки.
		$options = [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => $headers,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => json_encode((array)$params ?? [])
		];

		# Формируем параметры прокси.
		if ($this->isProxy) {
			$options[CURLOPT_PROXY] = $this->proxy_addr;
			$options[CURLOPT_PROXYPORT] = $this->proxy_port;
			$options[CURLOPT_PROXYTYPE] = $this->proxy_type;
			if (!empty($this->proxy_user)) $options[$this->proxy_opt] = $this->proxy_user . ":" . $this->proxy_pass;
		}

		# Отправляем запрос.
		curl_setopt_array($ch, $options);
		$response = curl_exec($ch);
		if (self::$debug) error_log(PHP_EOL . ">>>>>>>>>>" . PHP_EOL . var_export($params, true));
		curl_close($ch);

		# Валидация ответа.
		$validResponse = self::validate($response, true);
		if (!is_array($validResponse) || !($validResponse["ok"] ?? false)) {
			throw new TelegramMainException(message: $validResponse["description"] ?? "Unknown error", code: $validResponse["error_code"] ?? 0);
		}

		return $validResponse["result"] ?? null;
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
