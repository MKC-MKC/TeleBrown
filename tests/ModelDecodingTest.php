<?php

declare(strict_types=1);

use Haikiri\TeleBrown\Objects;
use Haikiri\TeleBrown\Objects\ChatMember\ChatMemberRestricted;
use Haikiri\TeleBrown\Objects\MessageOrigin\MessageOriginChannel;
use PHPUnit\Framework\TestCase;

final class ModelDecodingTest extends TestCase
{

	public function testPollOptionalEntitiesAndMultipleCorrectAnswers(): void
	{
		$poll = new Objects\Poll([
			"id" => "quiz", "question" => "Question", "type" => "quiz",
			"options" => [["persistent_id" => "a", "text" => "Answer", "voter_count" => 0]],
			"total_voter_count" => 0, "is_closed" => true, "is_anonymous" => true,
			"allows_multiple_answers" => true, "allows_revoting" => false, "members_only" => false,
			"correct_option_ids" => [0, 2],
			"media" => ["photo" => [["file_id" => "photo", "file_unique_id" => "unique", "width" => 100, "height" => 100]]],
		]);

		self::assertSame([], $poll->getQuestionEntities());
		self::assertSame([], $poll->getExplanationEntities());
		self::assertSame([], $poll->getOptions()[0]->getTextEntities());
		self::assertSame([0, 2], $poll->getCorrectOptionIds());
		self::assertSame("photo", $poll->getMedia()->getPhoto()[0]->getFileId());
		self::assertNull($poll->getMedia()->getVideo());
		self::assertNull($poll->getExplanationMedia());
	}

	public function testExternalReplyAndPaidMediaHydrateNestedObjects(): void
	{
		$reply = new Objects\ExternalReplyInfo([
			"origin" => ["type" => "channel", "date" => 1788960000, "chat" => ["id" => -1001234567890, "type" => "channel"], "message_id" => 42],
			"paid_media" => ["star_count" => 10, "paid_media" => [
				["type" => "preview", "width" => 640, "height" => 480, "duration" => 0],
				["type" => "photo", "photo" => [["file_id" => "photo", "file_unique_id" => "unique", "width" => 640, "height" => 480]]],
				["type" => "video", "video" => ["file_id" => "video", "file_unique_id" => "unique", "width" => 640, "height" => 480, "duration" => 5]],
				["type" => "live_photo", "live_photo" => ["file_id" => "live", "file_unique_id" => "unique", "width" => 640, "height" => 480, "duration" => 3]],
			]],
		]);

		self::assertInstanceOf(MessageOriginChannel::class, $reply->getOrigin());
		self::assertSame(-1001234567890, $reply->getOrigin()->getSenderUser()->getId());
		self::assertSame([], $reply->getPhoto());
		$media = $reply->getPaidMedia()->getPaidMedia();
		self::assertSame(0, $media[0]->getDuration());
		self::assertNull($media[0]->getVideo());
		self::assertSame("photo", $media[1]->getPhoto()[0]->getFileId());
		self::assertSame("video", $media[2]->getVideo()->getFileId());
		self::assertSame("live", $media[3]->getLivePhoto()->getFileId());
	}

	public function testPreviouslyEmptyUpdateModelsExposeSenderChatAndMemberChanges(): void
	{
		$user = ["id" => 17, "is_bot" => false, "first_name" => "User"];
		$chat = ["id" => -1001234567890, "type" => "supergroup"];
		$change = new Objects\Update(["chat_member" => [
			"chat" => $chat, "from" => $user, "date" => 1788960000,
			"old_chat_member" => ["status" => "member", "user" => $user],
			"new_chat_member" => ["status" => "restricted", "user" => $user, "is_member" => true, "can_send_messages" => false, "until_date" => 0],
		]]);

		self::assertSame(-1001234567890, $change->getChat()->getId());
		self::assertSame(17, $change->getUser()->getId());
		self::assertSame(1788960000, $change->getDate());
		self::assertSame("member", $change->getChatMember()->getOldChatMember()->getStatus());
		$restricted = $change->getChatMember()->getNewChatMember();
		self::assertInstanceOf(ChatMemberRestricted::class, $restricted);
		self::assertTrue($restricted->isMember());
		self::assertFalse($restricted->canSendMessages());

		$chosen = new Objects\Update(["chosen_inline_result" => ["result_id" => "result", "from" => $user, "query" => "music", "inline_message_id" => "inline"]]);
		self::assertSame(17, $chosen->getUser()->getId());
		self::assertSame("inline", $chosen->getChosenInlineResult()->getInlineMessageId());
		self::assertNull($chosen->getChosenInlineResult()->getLocation());

		$deleted = new Objects\Update(["deleted_business_messages" => ["business_connection_id" => "business", "chat" => $chat, "message_ids" => [41, 42]]]);
		self::assertSame(-1001234567890, $deleted->getChat()->getId());
		self::assertSame([41, 42], $deleted->getDeletedBusinessMessages()->getMessageIds());
	}

}
