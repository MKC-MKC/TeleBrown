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

final class TeleBrownServerChatInformationMethodsTest extends TestCase
{

	public function testChatInformationReturnsFullModel(): void
	{
		$history = [];
		$data = ["id" => -1001234567890, "type" => "supergroup", "title" => "Chat", "accent_color_id" => 1, "max_reaction_count" => 3];
		$server = $this->createServer($history, $data);

		$result = $server->getChat("@example");

		self::assertInstanceOf(Objects\ChatFullInfo::class, $result);
		self::assertSame($data, $result->getAsArray());
		self::assertSame("/bot123:TOKEN/getChat", $history[0]["request"]->getUri()->getPath());
		self::assertSame(["chat_id" => "@example"], json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));
	}

	public function testChatMemberUsesStatusToSelectModel(): void
	{
		$classes = [
			"creator" => Objects\ChatMember\ChatMemberOwner::class,
			"administrator" => Objects\ChatMember\ChatMemberAdministrator::class,
			"member" => Objects\ChatMember\ChatMemberMember::class,
			"restricted" => Objects\ChatMember\ChatMemberRestricted::class,
			"left" => Objects\ChatMember\ChatMemberLeft::class,
			"kicked" => Objects\ChatMember\ChatMemberBanned::class,
		];
		foreach ($classes as $status => $class) {
			$history = [];
			$data = ["status" => $status, "user" => ["id" => 42, "is_bot" => false, "first_name" => "User"]];
			$server = $this->createServer($history, $data);

			$result = $server->getChatMember(-1001234567890, 42);

			self::assertInstanceOf($class, $result);
			self::assertSame($data, $result->getAsArray());
			self::assertSame("/bot123:TOKEN/getChatMember", $history[0]["request"]->getUri()->getPath());
			self::assertSame(["chat_id" => -1001234567890, "user_id" => 42], json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));
		}
	}

	public function testAdministratorsReturnTypedMembersAndPreserveFalse(): void
	{
		foreach ([null, false, true] as $returnBots) {
			$history = [];
			$data = [
				["status" => "creator", "user" => ["id" => 42, "is_bot" => false, "first_name" => "Owner"]],
				["status" => "administrator", "user" => ["id" => 43, "is_bot" => true, "first_name" => "Bot"]],
			];
			$server = $this->createServer($history, $data);

			$result = $server->getChatAdministrators("@example", $returnBots);

			self::assertInstanceOf(Objects\ChatMember\ChatMemberOwner::class, $result[0]);
			self::assertInstanceOf(Objects\ChatMember\ChatMemberAdministrator::class, $result[1]);
			self::assertSame($data, array_map(static fn(Objects\ChatMember $member): array => $member->getAsArray(), $result));
			$expected = ["chat_id" => "@example"];
			if ($returnBots !== null) {
				$expected["return_bots"] = $returnBots;
			}
			self::assertSame("/bot123:TOKEN/getChatAdministrators", $history[0]["request"]->getUri()->getPath());
			self::assertSame($expected, json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));
		}
		$history = [];
		self::assertSame([], $this->createServer($history, [])->getChatAdministrators(42));
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
