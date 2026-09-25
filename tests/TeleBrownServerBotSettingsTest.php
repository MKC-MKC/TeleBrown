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

	public function testAdministratorRightsSerializeFalseAndCanBeCleared(): void
	{
		$history = [];
		self::assertTrue($this->createServer($history, true)->setMyDefaultAdministratorRights(new Objects\ChatAdministratorRights(["is_anonymous" => false, "can_manage_chat" => true]), false));
		self::assertSame(["rights" => ["is_anonymous" => false, "can_manage_chat" => true], "for_channels" => false], json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));
		$history = [];
		self::assertTrue($this->createServer($history, true)->setMyDefaultAdministratorRights());
		self::assertSame([], json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));
	}

	public function testCommandsAreHydratedAndEmptyResultIsAllowed(): void
	{
		$history = [];
		$commands = $this->createServer($history, [["command" => "start", "description" => "Начать", "is_ephemeral" => true]])->getMyCommands(new Objects\BotCommandScope(["type" => "chat_member", "chat_id" => -100123, "user_id" => 456]), "");
		self::assertSame("start", $commands[0]->getCommand());
		self::assertSame("Начать", $commands[0]->getDescription());
		self::assertTrue($commands[0]->isEphemeral());
		self::assertSame(["scope" => ["type" => "chat_member", "chat_id" => -100123, "user_id" => 456], "language_code" => ""], json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));
		$history = [];
		self::assertSame([], $this->createServer($history, [])->getMyCommands());
	}

	public function testCommandModelsSerializeWithScopeAndEmptyLanguage(): void
	{
		$history = [];
		self::assertTrue($this->createServer($history, true)->setMyCommands([new Objects\BotCommand(["command" => "start", "description" => "Начать", "is_ephemeral" => false])], new Objects\BotCommandScope(["type" => "default"]), ""));
		self::assertSame(["commands" => [["command" => "start", "description" => "Начать", "is_ephemeral" => false]], "scope" => ["type" => "default"], "language_code" => ""], json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));
	}

	public function testMenuButtonHydratesWebAppAndDefaultVariant(): void
	{
		$history = [];
		$button = $this->createServer($history, ["type" => "web_app", "text" => "Открыть", "web_app" => ["url" => "https://example.com/app"]])->getChatMenuButton();
		self::assertSame("web_app", $button->getType());
		self::assertSame("Открыть", $button->getText());
		self::assertSame("https://example.com/app", $button->getWebApp()->getUrl());
		$default = new Objects\MenuButton(["type" => "default"]);
		self::assertNull($default->getText());
		self::assertNull($default->getWebApp());
	}

	public function testMenuButtonSerializesNestedWebApp(): void
	{
		$history = [];
		self::assertTrue($this->createServer($history, true)->setChatMenuButton(menuButton: new Objects\MenuButton(["type" => "web_app", "text" => "Открыть", "web_app" => new Objects\WebAppInfo(["url" => "https://example.com/app"])])));
		self::assertSame(["menu_button" => ["type" => "web_app", "text" => "Открыть", "web_app" => ["url" => "https://example.com/app"]]], json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));
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
