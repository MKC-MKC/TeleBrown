<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Haikiri\TeleBrown\Enums\EmojiEnum;
use Haikiri\TeleBrown\Objects\ReactionTypeCustomEmoji;
use Haikiri\TeleBrown\TeleBrownServer;
use PHPUnit\Framework\TestCase;

final class TeleBrownServerContractParametersTest extends TestCase
{

	public function testEmptyAllowedUpdatesAreSentWhileOmittedValueIsNotSent(): void
	{
		$history = [];
		$server = $this->createServer($history, 4);

		$server->getUpdates();
		$server->getUpdates(allowedUpdates: []);
		$server->setWebhook("https://bot.example.test/hook");
		$server->setWebhook("https://bot.example.test/hook", allowedUpdates: []);

		self::assertSame([], $this->requestBody($history, 0));
		self::assertSame(["allowed_updates" => []], $this->requestBody($history, 1));
		self::assertSame(["url" => "https://bot.example.test/hook"], $this->requestBody($history, 2));
		self::assertSame(["url" => "https://bot.example.test/hook", "allowed_updates" => []], $this->requestBody($history, 3));
	}

	public function testBanSenderChatSendsOptionalUntilDate(): void
	{
		$history = [];
		$server = $this->createServer($history, 2);

		$server->banChatSenderChat(-1000000000042, -1000000000073);
		$server->banChatSenderChat(-1000000000042, -1000000000073, 1788960000);

		self::assertSame(
			["chat_id" => -1000000000042, "sender_chat_id" => -1000000000073],
			$this->requestBody($history, 0),
		);
		self::assertSame(
			["chat_id" => -1000000000042, "sender_chat_id" => -1000000000073, "until_date" => 1788960000],
			$this->requestBody($history, 1),
		);
	}

	public function testMessageReactionAcceptsEmojiAndCustomEmojiObjects(): void
	{
		$history = [];
		$server = $this->createServer($history, 2);

		$server->setMessageReaction(-1000000000042, 17, EmojiEnum::RED_HEART);
		$server->setMessageReaction(-1000000000042, 18, new ReactionTypeCustomEmoji("5368324170671202286"));

		self::assertSame(
			[
				"chat_id" => -1000000000042,
				"message_id" => 17,
				"reaction" => [["type" => "emoji", "emoji" => EmojiEnum::RED_HEART->value]],
			],
			$this->requestBody($history, 0),
		);
		self::assertSame(
			[
				"chat_id" => -1000000000042,
				"message_id" => 18,
				"reaction" => [["type" => "custom_emoji", "custom_emoji_id" => "5368324170671202286"]],
			],
			$this->requestBody($history, 1),
		);
	}

	private function createServer(array &$history, int $responseCount): TeleBrownServer
	{
		$mock = new MockHandler(array_map(
			static fn(): GuzzleResponse => new GuzzleResponse(200, [], '{"ok":true,"result":[]}'),
			range(1, $responseCount),
		));
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

	private function requestBody(array $history, int $index): array
	{
		return json_decode((string)$history[$index]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR);
	}

}
