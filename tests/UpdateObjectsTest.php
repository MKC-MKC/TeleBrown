<?php

declare(strict_types=1);

use Haikiri\TeleBrown\Enums\UpdateEnum;
use Haikiri\TeleBrown\Objects\ChatBoost;
use Haikiri\TeleBrown\Objects\ChatBoostSource;
use Haikiri\TeleBrown\Objects\ChatInviteLink;
use Haikiri\TeleBrown\Objects\ReactionCount;
use Haikiri\TeleBrown\Objects\ReactionType;
use Haikiri\TeleBrown\Objects\Update;
use PHPUnit\Framework\TestCase;

final class UpdateObjectsTest extends TestCase
{

	public function testDecodesChatJoinRequest(): void
	{
		$update = new Update([
			"update_id" => 101,
			"chat_join_request" => [
				"chat" => ["id" => -1001, "type" => "supergroup", "title" => "Community"],
				"from" => ["id" => 701, "is_bot" => false, "first_name" => "Robin"],
				"user_chat_id" => 9007199254740,
				"date" => 1788880001,
				"bio" => "Hello",
				"invite_link" => [
					"invite_link" => "https://t.me/+example",
					"creator" => ["id" => 702, "is_bot" => false, "first_name" => "Admin"],
					"creates_join_request" => true,
					"is_primary" => false,
					"is_revoked" => false,
					"name" => "Applicants",
					"expire_date" => 1789990001,
					"member_limit" => 50,
					"pending_join_request_count" => 3,
					"subscription_period" => 2592000,
					"subscription_price" => 100,
				],
				"query_id" => "join-query-1",
			],
		]);

		$request = $update->getChatJoinRequest();
		$link = $request->getInviteLink();

		self::assertSame(UpdateEnum::CHAT_JOIN_REQUEST, $update->getType());
		self::assertSame(-1001, $request->getChat()->getId());
		self::assertSame(701, $request->getFrom()->getId());
		self::assertSame(9007199254740, $request->getUserChatId());
		self::assertSame(1788880001, $request->getDate());
		self::assertSame("Hello", $request->getBio());
		self::assertSame("join-query-1", $request->getQueryId());
		self::assertInstanceOf(ChatInviteLink::class, $link);
		self::assertSame("https://t.me/+example", $link->getInviteLink());
		self::assertSame(702, $link->getCreator()->getId());
		self::assertTrue($link->createsJoinRequest());
		self::assertFalse($link->isPrimary());
		self::assertFalse($link->isRevoked());
		self::assertSame("Applicants", $link->getName());
		self::assertSame(1789990001, $link->getExpireDate());
		self::assertSame(50, $link->getMemberLimit());
		self::assertSame(3, $link->getPendingJoinRequestCount());
		self::assertSame(2592000, $link->getSubscriptionPeriod());
		self::assertSame(100, $link->getSubscriptionPrice());
		self::assertSame(-1001, $update->getChat()?->getId());
		self::assertSame(701, $update->getUser()?->getId());
		self::assertSame(1788880001, $update->getDate());
	}

	public function testDecodesPollAnswer(): void
	{
		$update = new Update([
			"update_id" => 102,
			"poll_answer" => [
				"poll_id" => "poll-1",
				"user" => ["id" => 703, "is_bot" => false, "first_name" => "Voter"],
				"option_ids" => [0, 2],
				"option_persistent_ids" => ["answer-a", "answer-c"],
			],
		]);
		$anonymousUpdate = new Update([
			"update_id" => 107,
			"poll_answer" => [
				"poll_id" => "poll-2",
				"voter_chat" => ["id" => -1006, "type" => "channel", "title" => "Anonymous"],
				"option_ids" => [],
				"option_persistent_ids" => [],
			],
		]);

		$answer = $update->getPollAnswer();

		self::assertSame(UpdateEnum::POLL_ANSWER, $update->getType());
		self::assertSame("poll-1", $answer->getPollId());
		self::assertNull($answer->getVoterChat());
		self::assertSame(703, $answer->getUser()?->getId());
		self::assertSame([0, 2], $answer->getOptionIds());
		self::assertSame(["answer-a", "answer-c"], $answer->getOptionPersistentIds());
		self::assertSame(703, $update->getUser()?->getId());
		self::assertSame(-1006, $anonymousUpdate->getPollAnswer()->getVoterChat()?->getId());
		self::assertNull($anonymousUpdate->getPollAnswer()->getUser());
		self::assertSame([], $anonymousUpdate->getPollAnswer()->getOptionIds());
		self::assertSame([], $anonymousUpdate->getPollAnswer()->getOptionPersistentIds());
		self::assertSame(-1006, $anonymousUpdate->getChat()?->getId());
	}

	public function testDecodesMessageReaction(): void
	{
		$update = new Update([
			"update_id" => 103,
			"message_reaction" => [
				"chat" => ["id" => -1002, "type" => "supergroup", "title" => "Reactions"],
				"message_id" => 55,
				"actor_chat" => ["id" => -1003, "type" => "channel", "title" => "Anonymous"],
				"date" => 1788880002,
				"old_reaction" => [["type" => "emoji", "emoji" => "👍"]],
				"new_reaction" => [
					["type" => "custom_emoji", "custom_emoji_id" => "custom-1"],
					["type" => "paid"],
				],
			],
		]);

		$reaction = $update->getMessageReaction();
		$oldReaction = $reaction->getOldReaction();
		$newReaction = $reaction->getNewReaction();

		self::assertSame(UpdateEnum::MESSAGE_REACTION, $update->getType());
		self::assertSame(-1002, $reaction->getChat()->getId());
		self::assertSame(55, $reaction->getMessageId());
		self::assertNull($reaction->getUser());
		self::assertSame(-1003, $reaction->getActorChat()?->getId());
		self::assertSame(1788880002, $reaction->getDate());
		self::assertContainsOnlyInstancesOf(ReactionType::class, $oldReaction);
		self::assertSame("emoji", $oldReaction[0]->getType());
		self::assertSame("👍", $oldReaction[0]->getEmoji());
		self::assertSame("custom_emoji", $newReaction[0]->getType());
		self::assertSame("custom-1", $newReaction[0]->getCustomEmojiId());
		self::assertSame("paid", $newReaction[1]->getType());
		self::assertNull($newReaction[1]->getEmoji());
		self::assertSame(-1002, $update->getChat()?->getId());
		self::assertNull($update->getUser());
		self::assertSame(1788880002, $update->getDate());
	}

	public function testDecodesMessageReactionCount(): void
	{
		$update = new Update([
			"update_id" => 104,
			"message_reaction_count" => [
				"chat" => ["id" => -1004, "type" => "channel", "title" => "News"],
				"message_id" => 56,
				"date" => 1788880003,
				"reactions" => [
					["type" => ["type" => "emoji", "emoji" => "🔥"], "total_count" => 7],
				],
			],
		]);

		$reactionCount = $update->getMessageReactionCount();
		$reactions = $reactionCount->getReactions();

		self::assertSame(UpdateEnum::MESSAGE_REACTION_COUNT, $update->getType());
		self::assertSame(-1004, $reactionCount->getChat()->getId());
		self::assertSame(56, $reactionCount->getMessageId());
		self::assertSame(1788880003, $reactionCount->getDate());
		self::assertContainsOnlyInstancesOf(ReactionCount::class, $reactions);
		self::assertInstanceOf(ReactionType::class, $reactions[0]->getType());
		self::assertSame("emoji", $reactions[0]->getType()->getType());
		self::assertSame("🔥", $reactions[0]->getType()->getEmoji());
		self::assertSame(7, $reactions[0]->getTotalCount());
		self::assertSame(1788880003, $update->getDate());
	}

	public function testDecodesChatBoostUpdates(): void
	{
		$added = new Update([
			"update_id" => 105,
			"chat_boost" => [
				"chat" => ["id" => -1005, "type" => "supergroup", "title" => "Boosted"],
				"boost" => [
					"boost_id" => "boost-1",
					"add_date" => 1788880004,
					"expiration_date" => 1791472004,
					"source" => [
						"source" => "premium",
						"user" => ["id" => 704, "is_bot" => false, "first_name" => "Booster"],
					],
				],
			],
		]);
		$removed = new Update([
			"update_id" => 106,
			"removed_chat_boost" => [
				"chat" => ["id" => -1005, "type" => "supergroup", "title" => "Boosted"],
				"boost_id" => "boost-2",
				"remove_date" => 1788880005,
				"source" => [
					"source" => "giveaway",
					"giveaway_message_id" => 88,
					"prize_star_count" => 5000,
					"is_unclaimed" => true,
				],
			],
		]);

		$boost = $added->getChatBoost()->getBoost();
		$removedSource = $removed->getRemovedChatBoost()->getSource();

		self::assertSame(UpdateEnum::CHAT_BOOST, $added->getType());
		self::assertInstanceOf(ChatBoost::class, $boost);
		self::assertSame("boost-1", $boost->getBoostId());
		self::assertSame(1788880004, $boost->getAddDate());
		self::assertSame(1791472004, $boost->getExpirationDate());
		self::assertInstanceOf(ChatBoostSource::class, $boost->getSource());
		self::assertSame("premium", $boost->getSource()->getSource());
		self::assertSame(704, $boost->getSource()->getUser()?->getId());
		self::assertSame(-1005, $added->getChat()?->getId());
		self::assertSame(704, $added->getUser()?->getId());
		self::assertSame(1788880004, $added->getDate());
		self::assertSame(UpdateEnum::REMOVED_CHAT_BOOST, $removed->getType());
		self::assertSame("boost-2", $removed->getRemovedChatBoost()->getBoostId());
		self::assertSame(1788880005, $removed->getRemovedChatBoost()->getRemoveDate());
		self::assertInstanceOf(ChatBoostSource::class, $removedSource);
		self::assertSame("giveaway", $removedSource->getSource());
		self::assertSame(88, $removedSource->getGiveawayMessageId());
		self::assertSame(5000, $removedSource->getPrizeStarCount());
		self::assertTrue($removedSource->isUnclaimed());
		self::assertNull($removedSource->getUser());
		self::assertSame(1788880005, $removed->getDate());
	}

}
