<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects\ForumTopic;
use Haikiri\TeleBrown\Objects\Sticker;
use Haikiri\TeleBrown\TeleBrownServer;
use PHPUnit\Framework\TestCase;

final class TeleBrownServerForumTopicsTest extends TestCase
{

	public function testCreateTopicDecodesResultAndOmitsOptionalParameters(): void
	{
		$history = [];
		$payload = ["message_thread_id" => 42, "name" => "Обсуждение", "icon_color" => 7322096];
		$server = $this->createServer($history, [$payload, $payload + ["icon_custom_emoji_id" => "5368324170671202286"]]);

		$topic = $server->createForumTopic(-1001234567890, "Обсуждение");
		$customTopic = $server->createForumTopic("@forum", "Обсуждение", 7322096, "5368324170671202286");

		self::assertInstanceOf(ForumTopic::class, $topic);
		self::assertSame(42, $topic->getMessageThreadId());
		self::assertSame("Обсуждение", $topic->getName());
		self::assertSame(7322096, $topic->getIconColor());
		self::assertSame("5368324170671202286", $customTopic->getIconCustomEmojiId());
		$this->assertRequest($history, 0, "createForumTopic", ["chat_id" => -1001234567890, "name" => "Обсуждение"]);
		$this->assertRequest($history, 1, "createForumTopic", [
			"chat_id" => "@forum", "name" => "Обсуждение",
			"icon_color" => 7322096, "icon_custom_emoji_id" => "5368324170671202286",
		]);
	}

	public function testEditTopicPreservesEmptyValuesAndOmitsNulls(): void
	{
		$history = [];
		$server = $this->createServer($history, [true, true, true]);

		self::assertTrue($server->editForumTopic("@forum", 42));
		self::assertTrue($server->editForumTopic("@forum", 42, "", ""));
		self::assertTrue($server->editForumTopic("@forum", 42, "Новое название", "5368324170671202286"));

		$params = ["chat_id" => "@forum", "message_thread_id" => 42];
		$this->assertRequest($history, 0, "editForumTopic", $params);
		$this->assertRequest($history, 1, "editForumTopic", $params + ["name" => "", "icon_custom_emoji_id" => ""]);
		$this->assertRequest($history, 2, "editForumTopic", $params + [
			"name" => "Новое название", "icon_custom_emoji_id" => "5368324170671202286",
		]);
	}

	public function testTopicLifecycleAndGeneralTopicRoutes(): void
	{
		$history = [];
		$calls = [
			["closeForumTopic", ["@forum", 42], ["chat_id" => "@forum", "message_thread_id" => 42]],
			["reopenForumTopic", ["@forum", 42], ["chat_id" => "@forum", "message_thread_id" => 42]],
			["deleteForumTopic", ["@forum", 42], ["chat_id" => "@forum", "message_thread_id" => 42]],
			["unpinAllForumTopicMessages", ["@forum", 42], ["chat_id" => "@forum", "message_thread_id" => 42]],
			["editGeneralForumTopic", ["@forum", "Общее"], ["chat_id" => "@forum", "name" => "Общее"]],
			["closeGeneralForumTopic", ["@forum"], ["chat_id" => "@forum"]],
			["reopenGeneralForumTopic", ["@forum"], ["chat_id" => "@forum"]],
			["hideGeneralForumTopic", ["@forum"], ["chat_id" => "@forum"]],
			["unhideGeneralForumTopic", ["@forum"], ["chat_id" => "@forum"]],
			["unpinAllGeneralForumTopicMessages", ["@forum"], ["chat_id" => "@forum"]],
		];
		$server = $this->createServer($history, array_fill(0, count($calls), true));

		foreach ($calls as $index => [$method, $arguments, $params]) {
			self::assertTrue($server->$method(...$arguments));
			$this->assertRequest($history, $index, $method, $params);
		}
	}

	public function testTopicIconsAreDecodedAsStickers(): void
	{
		$history = [];
		$server = $this->createServer($history, [[[
			"file_id" => "sticker-file", "file_unique_id" => "sticker-unique", "type" => "custom_emoji",
			"width" => 100, "height" => 100, "is_animated" => false, "is_video" => false,
			"custom_emoji_id" => "5368324170671202286",
		]], []]);

		$icons = $server->getForumTopicIconStickers();

		self::assertCount(1, $icons);
		self::assertInstanceOf(Sticker::class, $icons[0]);
		self::assertSame("5368324170671202286", $icons[0]->getCustomEmojiId());
		$this->assertRequest($history, 0, "getForumTopicIconStickers", []);
		self::assertSame([], $server->getForumTopicIconStickers());
	}

	public function testTelegramErrorIsNotReportedAsSuccessfulDeletion(): void
	{
		$history = [];
		$server = $this->createServer($history, [], [
			new GuzzleResponse(200, [], '{"ok":false,"error_code":400,"description":"Bad Request: TOPIC_ID_INVALID"}'),
		]);

		$this->expectException(TelegramMainException::class);
		$this->expectExceptionMessage("TOPIC_ID_INVALID");

		$server->deleteForumTopic("@forum", 42);
	}

	private function createServer(array &$history, array $results, array $responses = []): TeleBrownServer
	{
		$mock = new MockHandler(array_merge(array_map(
			static fn($result): GuzzleResponse => new GuzzleResponse(
				200, [], json_encode(["ok" => true, "result" => $result], JSON_THROW_ON_ERROR),
			),
			$results,
		), $responses));
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

	private function assertRequest(array $history, int $index, string $method, array $params): void
	{
		self::assertSame(
			"https://telegram.example.test/bot123:TOKEN/" . $method,
			(string)$history[$index]["request"]->getUri(),
		);
		self::assertSame(
			$params,
			json_decode((string)$history[$index]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR),
		);
	}

}
