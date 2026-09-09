<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Haikiri\TeleBrown\Objects\ChatAdministratorRights;
use Haikiri\TeleBrown\Objects\ChatMember\ChatMemberAdministrator;
use Haikiri\TeleBrown\Objects\SuggestedPostParameters;
use Haikiri\TeleBrown\TeleBrownServer;
use PHPUnit\Framework\TestCase;

final class TeleBrownServerDirectMessagesTest extends TestCase
{

	public function testMessageRoutesPassDirectMessagesParameters(): void
	{
		$history = [];
		$server = $this->createServer($history);
		$suggestion = new SuggestedPostParameters(["send_date" => 1788960000]);

		$server->sendMessage(
			chatId: -1000000000042,
			text: "Suggestion",
			directMessagesTopicId: 9007199254740991,
			suggestedPostParameters: $suggestion,
		);
		$server->forwardMessage(
			chatId: -1000000000042,
			fromChatId: 17,
			messageId: 21,
			directMessagesTopicId: 9007199254740991,
			suggestedPostParameters: $suggestion,
			messageEffectId: "effect-42",
		);
		$server->forwardMessages(
			chatId: -1000000000042,
			fromChatId: 17,
			messageIds: [21, 22],
			directMessagesTopicId: 9007199254740991,
			messageEffectId: "effect-42",
			suggestedPostParameters: $suggestion,
		);
		$server->sendContact(
			chatId: -1000000000042,
			phoneNumber: "+79990000000",
			firstName: "Miau",
			businessConnectionId: "business-42",
			directMessagesTopicId: 9007199254740991,
			suggestedPostParameters: $suggestion,
		);

		self::assertSame(
			[
				"chat_id" => -1000000000042,
				"text" => "Suggestion",
				"direct_messages_topic_id" => 9007199254740991,
				"suggested_post_parameters" => ["send_date" => 1788960000],
			],
			$this->requestBody($history, 0),
		);
		self::assertSame(
			[
				"chat_id" => -1000000000042,
				"from_chat_id" => 17,
				"message_id" => 21,
				"direct_messages_topic_id" => 9007199254740991,
				"message_effect_id" => "effect-42",
				"suggested_post_parameters" => ["send_date" => 1788960000],
			],
			$this->requestBody($history, 1),
		);
		self::assertSame(
			[
				"chat_id" => -1000000000042,
				"direct_messages_topic_id" => 9007199254740991,
				"from_chat_id" => 17,
				"message_ids" => [21, 22],
				"message_effect_id" => "effect-42",
				"suggested_post_parameters" => ["send_date" => 1788960000],
			],
			$this->requestBody($history, 2),
		);
		self::assertSame(
			[
				"chat_id" => -1000000000042,
				"business_connection_id" => "business-42",
				"phone_number" => "+79990000000",
				"first_name" => "Miau",
				"direct_messages_topic_id" => 9007199254740991,
				"suggested_post_parameters" => ["send_date" => 1788960000],
			],
			$this->requestBody($history, 3),
		);
	}

	public function testAdministratorRightsExposeAndSendCurrentFields(): void
	{
		$history = [];
		$server = $this->createServer($history);
		$fields = [
			"can_manage_direct_messages" => true,
			"can_manage_tags" => true,
			"can_send_welcome_messages" => true,
		];

		$server->promoteChatMember(
			chatId: -1000000000042,
			userId: 73,
			canManageDirectMessages: true,
			canManageTags: true,
			canSendWelcomeMessages: true,
		);

		self::assertSame(
			["chat_id" => -1000000000042, "user_id" => 73] + $fields,
			$this->requestBody($history, 0),
		);
		$rights = new ChatAdministratorRights($fields);
		$member = new ChatMemberAdministrator($fields);
		self::assertTrue($rights->canManageDirectMessages());
		self::assertTrue($rights->canManageTags());
		self::assertTrue($rights->canSendWelcomeMessages());
		self::assertTrue($member->canManageDirectMessages());
		self::assertTrue($member->canManageTags());
		self::assertTrue($member->canSendWelcomeMessages());
	}

	private function createServer(array &$history): TeleBrownServer
	{
		$mock = new MockHandler([
			new GuzzleResponse(200, [], '{"ok":true,"result":{}}'),
			new GuzzleResponse(200, [], '{"ok":true,"result":{}}'),
			new GuzzleResponse(200, [], '{"ok":true,"result":[{"message_id":23}]}'),
			new GuzzleResponse(200, [], '{"ok":true,"result":{}}'),
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

	private function requestBody(array $history, int $index): array
	{
		return json_decode((string)$history[$index]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR);
	}

}
