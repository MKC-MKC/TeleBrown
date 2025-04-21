<?php

namespace Haikiri\TeleBrown;

class TeleBrownClient extends TeleBrownClientAbstract
{

	/**
	 * Метод получения ответа от API мессенджера.
	 *
	 * @return string
	 */
	public function getResponse(): string
	{
		if (empty($response = file_get_contents(filename: "php://input"))) return "";

		if (json_last_error() != JSON_ERROR_NONE) {
			if (self::$debug) error_log("json_last_error: " . json_last_error());
			if (self::$debug) error_log("json_last_error_msg: " . json_last_error_msg());
			return "";
		}

		$message = "\n[" . date("d.m.Y H:i:s") . "] ==- Incoming Response Data -== " . print_r(json_decode($response, true), true) . PHP_EOL;
		if (self::$debug) error_log($message);

		return (string)$response ?? "";
	}

}
