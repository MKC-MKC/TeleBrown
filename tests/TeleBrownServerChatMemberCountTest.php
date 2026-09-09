<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Haikiri\TeleBrown\TeleBrownServer;
use PHPUnit\Framework\TestCase;

final class TeleBrownServerChatMemberCountTest extends TestCase
{

	public function testGetChatMemberCountReturnsIntegerResult(): void
	{
		$history = [];
		$mock = new MockHandler([
			new GuzzleResponse(200, [], '{"ok":true,"result":42}'),
		]);
		$handler = HandlerStack::create($mock);
		$handler->push(Middleware::history($history));
		$server = new class("https://telegram.example.test", "123:TOKEN", $handler) extends TeleBrownServer {
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

		$result = $server->getChatMemberCount("@members");

		self::assertSame(42, $result);
		self::assertSame(
			"https://telegram.example.test/bot123:TOKEN/getChatMemberCount",
			(string)$history[0]["request"]->getUri(),
		);
		self::assertSame(
			["chat_id" => "@members"],
			json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR),
		);
	}

}
