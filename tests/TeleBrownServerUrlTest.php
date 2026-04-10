<?php

declare(strict_types=1);

use Haikiri\TeleBrown\TeleBrownServer;
use PHPUnit\Framework\TestCase;

final class TeleBrownServerUrlTest extends TestCase
{

	public static function testRequestUrlNormalization(): void
	{
		$method = "getMe";
		$token = "0123456789:TOKEN-EXAMPLE_HERE";
		$main_expected = "https://api.telegram.org/bot0123456789:TOKEN-EXAMPLE_HERE/getMe";
		$internal_expected = "https://tdlib.telegram-bot-api.local/bot0123456789:TOKEN-EXAMPLE_HERE/getMe";

		# Проверяем возможные кейсы.
		$cases = [
			[
				"url" => "https://api.telegram.org",
				"token" => $token,
				"expected" => $main_expected,
			],
			[
				"url" => "https://api.telegram.org/",
				"token" => $token,
				"expected" => $main_expected,
			],
			[
				"url" => "https://api.telegram.org/bot",
				"token" => $token,
				"expected" => $main_expected,
			],
			[
				"url" => "https://api.telegram.org/bot999999:OLD_TOKEN",
				"token" => $token,
				"expected" => $main_expected,
			],
			[
				"url" => "https://api.telegram.org/file/bot999999:OLD_TOKEN",
				"token" => $token,
				"expected" => $main_expected,
			],
			[
				"url" => "https://tdlib.telegram-bot-api.local",
				"token" => $token,
				"expected" => $internal_expected,
			],
			[
				"url" => "https://tdlib.telegram-bot-api.local/file/bot999999:OLD_TOKEN",
				"token" => $token,
				"expected" => $internal_expected,
			],
			[
				"url" => "https://tdlib.telegram-bot-api.local/file",
				"token" => $token,
				"expected" => "https://tdlib.telegram-bot-api.local/file/bot0123456789:TOKEN-EXAMPLE_HERE/getMe",
			],
		];

		# Проходимся по каждому кейсу.
		foreach ($cases as $case) {
			$server = new class($case["url"], $case["token"]) extends TeleBrownServer {
				public function exposeBuildRequestUrl(string $method): string
				{
					return $this->buildRequestUrl($method);
				}
			};

			self::assertSame($case["expected"], $server->exposeBuildRequestUrl($method), $case["url"]);
		}
	}

}
