<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Haikiri\TeleBrown\Objects\InlineKeyboardMarkup;
use Haikiri\TeleBrown\Objects\Poll;
use Haikiri\TeleBrown\TeleBrownServer;
use PHPUnit\Framework\TestCase;

final class TeleBrownServerPollTest extends TestCase
{

	public function testBothStopPollNamesUseOfficialRouteAndDecodePoll(): void
	{
		$history = [];
		$payload = [
			"id" => "9007199254740993", "question" => "Ready?",
			"options" => [["text" => "Yes", "voter_count" => 2], ["text" => "No", "voter_count" => 1]],
			"total_voter_count" => 3, "is_closed" => true, "is_anonymous" => true,
			"type" => "regular", "allows_multiple_answers" => false,
		];
		$response = json_encode(["ok" => true, "result" => $payload], JSON_THROW_ON_ERROR);
		$mock = new MockHandler([new GuzzleResponse(200, [], $response), new GuzzleResponse(200, [], $response)]);
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
		$markup = new InlineKeyboardMarkup(["inline_keyboard" => []]);

		// Старое имя сохраняет именованные аргументы, но не отправляет опечатку в HTTP-маршрут.
		foreach (["stopPoll", "stopPool"] as $index => $method) {
			$poll = $server->$method(
				businessConnectionId: "",
				chatId: "@poll_channel",
				messageId: 42,
				replyMarkup: $markup,
			);

			self::assertInstanceOf(Poll::class, $poll);
			self::assertSame("9007199254740993", $poll->getId());
			self::assertSame("Ready?", $poll->getQuestion());
			self::assertTrue($poll->isClosed());
			self::assertSame(3, $poll->getTotalVoterCount());
			self::assertSame("Yes", $poll->getOptions()[0]->getText());
			self::assertSame(2, $poll->getOptions()[0]->getVoterCount());
			self::assertSame("https://telegram.example.test/bot123:TOKEN/stopPoll", (string)$history[$index]["request"]->getUri());
			self::assertSame(
				["business_connection_id" => "", "chat_id" => "@poll_channel", "message_id" => 42, "reply_markup" => ["inline_keyboard" => []]],
				json_decode((string)$history[$index]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR),
			);
		}
	}

}
