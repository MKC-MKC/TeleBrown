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

final class TeleBrownServerChatInvitesMethodsTest extends TestCase
{

	public function testExportChatInviteLinkReturnsInviteLink(): void
	{
		$history = [];
		$data = "https://t.me/+example";
		$server = $this->createServer($history, $data);

		$result = $server->exportChatInviteLink("@example");

		self::assertSame($data, $result);
		self::assertSame("/bot123:TOKEN/exportChatInviteLink", $history[0]["request"]->getUri()->getPath());
		self::assertSame(["chat_id" => "@example"], json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));
	}

	public function testRevokeChatInviteLinkReturnsInviteLink(): void
	{
		$history = [];
		$data = ["invite_link" => "https://t.me/+example", "creator" => ["id" => 42, "is_bot" => true, "first_name" => "Bot"], "creates_join_request" => false, "is_primary" => false, "is_revoked" => true];
		$server = $this->createServer($history, $data);

		$result = $server->revokeChatInviteLink("@example", "https://t.me/+example");

		self::assertInstanceOf(Objects\ChatInviteLink::class, $result);
		self::assertSame($data, $result->getAsArray());
		self::assertSame("/bot123:TOKEN/revokeChatInviteLink", $history[0]["request"]->getUri()->getPath());
		self::assertSame(["chat_id" => "@example", "invite_link" => "https://t.me/+example"], json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));
	}

	public function testCreateChatSubscriptionInviteLinkReturnsInviteLink(): void
	{
		$history = [];
		$data = ["invite_link" => "https://t.me/+example", "creator" => ["id" => 42, "is_bot" => true, "first_name" => "Bot"], "creates_join_request" => false, "is_primary" => false, "is_revoked" => false];
		$server = $this->createServer($history, $data);

		$result = $server->createChatSubscriptionInviteLink("@example", 2592000, 100, "Members");

		self::assertInstanceOf(Objects\ChatInviteLink::class, $result);
		self::assertSame($data, $result->getAsArray());
		self::assertSame("/bot123:TOKEN/createChatSubscriptionInviteLink", $history[0]["request"]->getUri()->getPath());
		self::assertSame(["chat_id" => "@example", "subscription_period" => 2592000, "subscription_price" => 100, "name" => "Members"], json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));
	}

	public function testEditChatSubscriptionInviteLinkReturnsInviteLink(): void
	{
		$history = [];
		$data = ["invite_link" => "https://t.me/+example", "creator" => ["id" => 42, "is_bot" => true, "first_name" => "Bot"], "creates_join_request" => false, "is_primary" => false, "is_revoked" => false];
		$server = $this->createServer($history, $data);

		$result = $server->editChatSubscriptionInviteLink("@example", "https://t.me/+example", "");

		self::assertInstanceOf(Objects\ChatInviteLink::class, $result);
		self::assertSame($data, $result->getAsArray());
		self::assertSame("/bot123:TOKEN/editChatSubscriptionInviteLink", $history[0]["request"]->getUri()->getPath());
		self::assertSame(["chat_id" => "@example", "invite_link" => "https://t.me/+example", "name" => ""], json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));
	}

	private function createServer(array &$history, array|string $result): TeleBrownServer
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
