<?php

declare(strict_types=1);

use Haikiri\TeleBrown\Enums\MessageTypesEnum;
use Haikiri\TeleBrown\Objects\ForumTopic;
use Haikiri\TeleBrown\Objects\ForumTopicCreated;
use Haikiri\TeleBrown\Objects\ForumTopicEdited;
use Haikiri\TeleBrown\Objects\Message;
use Haikiri\TeleBrown\Objects\User;
use PHPUnit\Framework\TestCase;

final class ForumTopicObjectsTest extends TestCase
{

	public function testEmptyTopicServiceMessagesAreRecognized(): void
	{
		$events = [
			"forum_topic_closed" => MessageTypesEnum::FORUM_TOPIC_CLOSED,
			"forum_topic_reopened" => MessageTypesEnum::FORUM_TOPIC_REOPENED,
			"general_forum_topic_hidden" => MessageTypesEnum::GENERAL_FORUM_TOPIC_HIDDEN,
			"general_forum_topic_unhidden" => MessageTypesEnum::GENERAL_FORUM_TOPIC_UNHIDDEN,
		];

		foreach ($events as $field => $type) {
			$payload = json_decode('{"message_thread_id":42,"is_topic_message":true,"' . $field . '":{}}', true, 512, JSON_THROW_ON_ERROR);
			$message = new Message($payload);

			self::assertSame($type, $message->getType());
			self::assertSame(42, $message->getThreadId());
			self::assertTrue($message->isTopicMessage());
		}

		self::assertNull((new Message([]))->getType());
	}

	public function testTopicEventsAreNotMistakenForContactOrMemberEvents(): void
	{
		self::assertSame(MessageTypesEnum::FORUM_TOPIC_CREATED, (new Message([
			"forum_topic_created" => ["name" => "Обсуждение", "icon_color" => 7322096],
		]))->getType());
		self::assertSame(MessageTypesEnum::FORUM_TOPIC_EDITED, (new Message([
			"forum_topic_edited" => ["icon_custom_emoji_id" => ""],
		]))->getType());
		self::assertSame(MessageTypesEnum::CONTACT, (new Message([
			"contact" => ["phone_number" => "+123456789", "first_name" => "Robin"],
		]))->getType());
		self::assertSame(MessageTypesEnum::LEFT_CHAT_MEMBER, (new Message([
			"left_chat_member" => ["id" => 701, "is_bot" => false, "first_name" => "Robin"],
		]))->getType());
	}

	public function testEditedIconDistinguishesRemovalFromUnchangedValue(): void
	{
		self::assertNull((new ForumTopicEdited(["name" => "Новое название"]))->getIconCustomEmojiId());
		self::assertSame("", (new ForumTopicEdited(["icon_custom_emoji_id" => ""]))->getIconCustomEmojiId());
		self::assertSame("5368324170671202286", (new ForumTopicEdited([
			"icon_custom_emoji_id" => "5368324170671202286",
		]))->getIconCustomEmojiId());
	}

	public function testTopicFlagsDefaultToFalse(): void
	{
		self::assertFalse((new User([]))->hasTopicsEnabled());
		self::assertFalse((new User([]))->allowsUsersToCreateTopics());
		self::assertTrue((new User(["has_topics_enabled" => true]))->hasTopicsEnabled());
		self::assertTrue((new User(["allows_users_to_create_topics" => true]))->allowsUsersToCreateTopics());
		self::assertFalse((new ForumTopic([]))->isNameImplicit());
		self::assertTrue((new ForumTopic(["is_name_implicit" => true]))->isNameImplicit());
		self::assertFalse((new ForumTopicCreated([]))->isNameImplicit());
		self::assertTrue((new ForumTopicCreated(["is_name_implicit" => true]))->isNameImplicit());
	}

}
