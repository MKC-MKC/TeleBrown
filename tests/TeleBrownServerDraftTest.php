<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Haikiri\TeleBrown\Enums\ParseModeEnum;
use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\TeleBrownServer;
use PHPUnit\Framework\TestCase;

final class TeleBrownServerDraftTest extends TestCase
{

	public function testSendMessageDraftPassesContractParameters(): void
	{
		$history = [];
		$server = $this->createServer($history);
		$entities = [["type" => "bold", "offset" => 0, "length" => 7]];

		$result = $server->sendMessageDraft(
			chatId: 7174876173,
			draftId: 42,
			text: "Partial",
			messageThreadId: 15,
			parseMode: ParseModeEnum::HTML,
			entities: $entities,
			canStop: true,
			keepOnStop: false,
		);

		self::assertTrue($result);
		self::assertSame(
			[
				"chat_id" => 7174876173,
				"message_thread_id" => 15,
				"draft_id" => 42,
				"text" => "Partial",
				"parse_mode" => "HTML",
				"entities" => $entities,
				"can_stop" => true,
				"keep_on_stop" => false,
			],
			json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR),
		);
		self::assertSame(
			"https://api.telegram.org/bot123:TOKEN/sendMessageDraft",
			(string)$history[0]["request"]->getUri(),
		);
	}

	public function testSendMessageDraftPreservesEmptyTextAndOmitsUnsetParameters(): void
	{
		$history = [];
		$server = $this->createServer($history);

		$server->sendMessageDraft(chatId: 7174876173, draftId: -7, text: "");

		self::assertSame(
			[
				"chat_id" => 7174876173,
				"draft_id" => -7,
				"text" => "",
			],
			json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR),
		);
	}

	public function testSendMessageDraftRejectsZeroDraftIdBeforeRequest(): void
	{
		$history = [];
		$server = $this->createServer($history);

		$this->expectException(TelegramMainException::class);
		$this->expectExceptionMessage("Draft ID must be non-zero");

		try {
			$server->sendMessageDraft(chatId: 7174876173, draftId: 0);
		} finally {
			self::assertSame([], $history);
		}
	}

	private function createServer(array &$history): TeleBrownServer
	{
		$mock = new MockHandler([
			new GuzzleResponse(200, [], '{"ok":true,"result":true}'),
		]);
		$handler = HandlerStack::create($mock);
		$handler->push(Middleware::history($history));

		return new class("https://api.telegram.org", "123:TOKEN", $handler) extends TeleBrownServer {
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
