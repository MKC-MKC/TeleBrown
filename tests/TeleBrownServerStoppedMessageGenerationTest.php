<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Haikiri\TeleBrown\Enums\UpdateEnum;
use Haikiri\TeleBrown\Objects\MessageGenerationStopped;
use Haikiri\TeleBrown\TeleBrownServer;
use PHPUnit\Framework\TestCase;

final class TeleBrownServerStoppedMessageGenerationTest extends TestCase
{

	public function testGetUpdatesDecodesStoppedMessageGeneration(): void
	{
		$history = [];
		$mock = new MockHandler([
			new GuzzleResponse(200, [], json_encode([
				"ok" => true,
				"result" => [[
					"update_id" => 870000001,
					"stopped_message_generation" => [
						"chat" => ["id" => 7174876173, "type" => "private", "first_name" => "Robin"],
						"message_thread_id" => 15,
						"draft_id" => -42,
					],
				]],
			], JSON_THROW_ON_ERROR)),
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

		$updates = $server->getUpdates(
			offset: 870000001,
			allowedUpdates: [UpdateEnum::STOPPED_MESSAGE_GENERATION],
		);

		self::assertCount(1, $updates);
		self::assertSame(UpdateEnum::STOPPED_MESSAGE_GENERATION, $updates[0]->getType());
		self::assertInstanceOf(MessageGenerationStopped::class, $updates[0]->getStoppedMessageGeneration());
		self::assertSame(7174876173, $updates[0]->getStoppedMessageGeneration()->getChat()->getId());
		self::assertSame(15, $updates[0]->getStoppedMessageGeneration()->getMessageThreadId());
		self::assertSame(-42, $updates[0]->getStoppedMessageGeneration()->getDraftId());
		self::assertSame(7174876173, $updates[0]->getChat()?->getId());
		self::assertSame(
			["offset" => 870000001, "allowed_updates" => ["stopped_message_generation"]],
			json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR),
		);
	}

}
