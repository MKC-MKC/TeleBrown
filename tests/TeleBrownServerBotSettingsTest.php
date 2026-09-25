<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Haikiri\TeleBrown\Objects;
use Haikiri\TeleBrown\TeleBrownServer;
use PHPUnit\Framework\TestCase;

final class TeleBrownServerBotSettingsTest extends TestCase
{

	public function testManagedAccessPreservesFalseAndEmptyUsers(): void
	{
		$history = [];
		self::assertTrue($this->createServer($history, true)->setManagedBotAccessSettings(456, false, []));
		self::assertSame(["user_id" => 456, "is_access_restricted" => false, "added_user_ids" => []], json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));
	}

	public function testManagedAccessHydratesUsersAndPreservesEmptyList(): void
	{
		$history = [];
		$settings = $this->createServer($history, ["is_access_restricted" => true, "added_users" => [["id" => 123, "is_bot" => false, "first_name" => "Иван"]]])->getManagedBotAccessSettings(456);
		self::assertTrue($settings->isAccessRestricted());
		self::assertSame(123, $settings->getAddedUsers()[0]->getId());
		self::assertSame([], (new Objects\BotAccessSettings(["is_access_restricted" => false]))->getAddedUsers());
		self::assertFalse((new Objects\BotAccessSettings(["is_access_restricted" => false]))->isAccessRestricted());
	}

	private function createServer(array &$history, mixed $result): TeleBrownServer
	{
		$mock = new MockHandler([new GuzzleResponse(200, [], json_encode(["ok" => true, "result" => $result], JSON_THROW_ON_ERROR))]);
		$handler = HandlerStack::create($mock);
		$handler->push(Middleware::history($history));

		return new class("https://telegram.example.test", "123:TOKEN", $handler) extends TeleBrownServer {
			public function __construct(string $url, string $token, private readonly HandlerStack $handler)
			{
				parent::__construct($url, $token);
			}

			protected function createClient(array $options): Client
			{
				$options["handler"] = $this->handler;
				return parent::createClient($options);
			}
		};
	}

}
