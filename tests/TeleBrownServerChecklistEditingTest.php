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

final class TeleBrownServerChecklistEditingTest extends TestCase
{

	public function testChecklistEditingSerializesTasksAndReturnsMessage(): void
	{
		$history = [];
		$data = ["message_id" => 42, "date" => 1720000000, "chat" => ["id" => 123, "type" => "private"]];
		$server = $this->createServer($history, $data);
		$task = new Objects\InputChecklistTask(["id" => 1, "text" => "Task"]);
		$checklist = new Objects\InputChecklist(["title" => "Tasks", "tasks" => [$task], "others_can_add_tasks" => false]);
		$markup = new Objects\InlineKeyboardMarkup(["inline_keyboard" => []]);

		$result = $server->editMessageChecklist("business", "@example", 42, $checklist, $markup);

		self::assertInstanceOf(Objects\Message::class, $result);
		self::assertSame($data, $result->getAsArray());
		self::assertSame("/bot123:TOKEN/editMessageChecklist", $history[0]["request"]->getUri()->getPath());
		self::assertSame([
			"business_connection_id" => "business",
			"chat_id" => "@example",
			"message_id" => 42,
			"checklist" => ["title" => "Tasks", "tasks" => [["id" => 1, "text" => "Task"]], "others_can_add_tasks" => false],
			"reply_markup" => ["inline_keyboard" => []],
		], json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));
	}

	private function createServer(array &$history, array $result): TeleBrownServer
	{
		$mock = new MockHandler([
			new GuzzleResponse(200, [], json_encode(["ok" => true, "result" => $result], JSON_THROW_ON_ERROR)),
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
