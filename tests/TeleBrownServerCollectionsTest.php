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

final class TeleBrownServerCollectionsTest extends TestCase
{

	public function testProfilePhotoSizesAndAudioAreModels(): void
	{
		$photo = ["file_id" => "photo-id", "file_unique_id" => "unique-photo", "width" => 64, "height" => 64];
		$history = [];
		$server = $this->createServer($history, ["total_count" => 1, "photos" => [[$photo, $photo + ["file_size" => 200]]]]);
		$result = $server->getUserProfilePhotos(17, offset: 0, limit: 1);
		self::assertSame(1, $result->getTotalCount());
		self::assertCount(2, $result->getPhotos()[0]);
		self::assertSame("photo-id", $result->getPhotos()[0][1]->getFileId());
		self::assertSame(["user_id" => 17, "offset" => 0, "limit" => 1], json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR));

		$history = [];
		$server = $this->createServer($history, ["total_count" => 1, "audios" => [["file_id" => "audio-id", "file_unique_id" => "unique-audio", "duration" => 8]]]);
		$audios = $server->getUserProfileAudios(17);
		self::assertSame(1, $audios->getTotalCount());
		self::assertSame("audio-id", $audios->getAudios()[0]->getFileId());
		self::assertSame(8, $audios->getAudios()[0]->getDuration());
	}

	public function testCopyMessagesReturnsOnlyCopiedIdentifiers(): void
	{
		$history = [];
		$server = $this->createServer($history, [["message_id" => 50], ["message_id" => 51]]);
		$messages = $server->copyMessages(17, 18, [1, 2, 3], removeCaption: false);
		self::assertSame([50, 51], array_map(static fn(Objects\MessageId $message): int => $message->getId(), $messages));
		$body = json_decode((string)$history[0]["request"]->getBody(), true, 512, JSON_THROW_ON_ERROR);
		self::assertSame([1, 2, 3], $body["message_ids"]);
		self::assertFalse($body["remove_caption"]);

		$history = [];
		$server = $this->createServer($history, []);
		self::assertSame([], $server->copyMessages(17, 18, [1]));
	}

	private function createServer(array &$history, array $result): TeleBrownServer
	{
		$handler = HandlerStack::create(new MockHandler([new GuzzleResponse(200, [], json_encode(["ok" => true, "result" => $result], JSON_THROW_ON_ERROR))]));
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
