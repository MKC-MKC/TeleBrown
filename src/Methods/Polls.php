<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Enums;
use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects;

trait Polls
{

	/**
	 * Отправляет обычный опрос или викторину.
	 * Возвращается отправленное сообщение Message.
	 *
	 * @param int|string $chatId Идентификатор целевого чата или его @username.
	 * @param string $question Вопрос опроса, от 1 до 300 символов.
	 * @param Objects\InputPollOption[]|array $options От 1 до 12 вариантов ответа.
	 * @param string|null $businessConnectionId Идентификатор бизнес-подключения, от имени которого отправляется сообщение.
	 * @param int|null $messageThreadId Идентификатор темы форума; для супергрупп и личных чатов ботов с включённым режимом тем.
	 * @param Enums\ParseModeEnum|null $questionParseMode Режим разбора вопроса; разрешены только сущности пользовательских эмодзи.
	 * @param Objects\MessageEntity[]|array|null $questionEntities Сущности вопроса; можно указать вместо question_parse_mode.
	 * @param bool|null $isAnonymous True для анонимного опроса. По умолчанию True.
	 * @param string|null $type Тип опроса: quiz или regular. По умолчанию regular.
	 * @param bool|null $allowsMultipleAnswers Разрешает выбирать несколько ответов. По умолчанию False.
	 * @param bool|null $allowsRevoting Разрешает менять выбранные ответы. По умолчанию False для викторин, True для обычных опросов.
	 * @param bool|null $shuffleOptions Показывает варианты ответа в случайном порядке.
	 * @param bool|null $allowAddingOptions Разрешает добавлять варианты после создания; не поддерживается в анонимных опросах и викторинах.
	 * @param bool|null $hideResultsUntilCloses Показывает результаты только после закрытия опроса.
	 * @param bool|null $membersOnly Разрешает голосовать участникам, состоящим в чате более 24 часов; только для каналов.
	 * @param array|null $countryCodes От 0 до 12 кодов стран ISO 3166-1 alpha-2; только для каналов. FT разрешает анонимные номера. Пустой список разрешает все страны.
	 * @param array|null $correctOptionIds Индексы правильных ответов с нуля в возрастающем порядке; обязательны для викторин.
	 * @param string|null $explanation Пояснение к викторине, от 0 до 200 символов, не более двух переносов строк после разбора сущностей.
	 * @param Enums\ParseModeEnum|null $explanationParseMode Режим разбора сущностей пояснения.
	 * @param Objects\MessageEntity[]|array|null $explanationEntities Сущности пояснения; можно указать вместо explanation_parse_mode.
	 * @param Objects\InputPollMedia|null $explanationMedia Медиа пояснения викторины.
	 * @param int|null $openPeriod Время до закрытия от 5 до 2628000 секунд. Несовместимо с close_date.
	 * @param int|null $closeDate Время закрытия Unix, от 5 до 2628000 секунд в будущем. Несовместимо с open_period.
	 * @param bool|null $isClosed Передайте True для отправки сразу закрытого опроса.
	 * @param string|null $description Описание опроса, от 0 до 1024 символов после разбора сущностей.
	 * @param Enums\ParseModeEnum|null $descriptionParseMode Режим разбора сущностей описания.
	 * @param Objects\MessageEntity[]|array|null $descriptionEntities Сущности описания; можно указать вместо description_parse_mode.
	 * @param Objects\InputPollMedia|null $media Медиа, добавляемое к описанию опроса.
	 * @param bool|null $disableNotification Отправка без звука уведомления.
	 * @param bool|null $protectContent Защищает содержимое от пересылки и сохранения.
	 * @param bool|null $allowPaidBroadcast Разрешает до 1000 сообщений в секунду за 0,1 звезды Telegram за сообщение.
	 * @param string|null $messageEffectId Идентификатор эффекта сообщения; только для личных чатов.
	 * @param Objects\ReplyParameters|null $replyParameters Описание сообщения, на которое отправляется ответ.
	 * @param Objects\InlineKeyboardMarkup|Objects\ReplyKeyboardMarkup|Objects\ReplyKeyboardRemove|Objects\ForceReply|null $replyMarkup Inline-клавиатура, клавиатура ответа, её удаление или запрос ответа.
	 * @return Objects\Message
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#sendpoll
	 */
	public function sendPoll(
		int|string                                                                                                   $chatId,
		string                                                                                                       $question,
		array                                                                                                        $options,
		string|null                                                                                                  $businessConnectionId = null,
		int|null                                                                                                     $messageThreadId = null,
		Enums\ParseModeEnum|null                                                                                     $questionParseMode = null,
		array|null                                                                                                   $questionEntities = null,
		bool|null                                                                                                    $isAnonymous = null,
		string|null                                                                                                  $type = null,
		bool|null                                                                                                    $allowsMultipleAnswers = null,
		bool|null                                                                                                    $allowsRevoting = null,
		bool|null                                                                                                    $shuffleOptions = null,
		bool|null                                                                                                    $allowAddingOptions = null,
		bool|null                                                                                                    $hideResultsUntilCloses = null,
		bool|null                                                                                                    $membersOnly = null,
		array|null                                                                                                   $countryCodes = null,
		array|null                                                                                                   $correctOptionIds = null,
		string|null                                                                                                  $explanation = null,
		Enums\ParseModeEnum|null                                                                                     $explanationParseMode = null,
		array|null                                                                                                   $explanationEntities = null,
		Objects\InputPollMedia|null                                                                                  $explanationMedia = null,
		int|null                                                                                                     $openPeriod = null,
		int|null                                                                                                     $closeDate = null,
		bool|null                                                                                                    $isClosed = null,
		string|null                                                                                                  $description = null,
		Enums\ParseModeEnum|null                                                                                     $descriptionParseMode = null,
		array|null                                                                                                   $descriptionEntities = null,
		Objects\InputPollMedia|null                                                                                  $media = null,
		bool|null                                                                                                    $disableNotification = null,
		bool|null                                                                                                    $protectContent = null,
		bool|null                                                                                                    $allowPaidBroadcast = null,
		string|null                                                                                                  $messageEffectId = null,
		Objects\ReplyParameters|null                                                                                 $replyParameters = null,
		Objects\InlineKeyboardMarkup|Objects\ReplyKeyboardMarkup|Objects\ReplyKeyboardRemove|Objects\ForceReply|null $replyMarkup = null,
	): Objects\Message
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"question" => $question,
				"options" => $options,
				"business_connection_id" => $businessConnectionId,
				"message_thread_id" => $messageThreadId,
				"question_parse_mode" => $questionParseMode?->value,
				"question_entities" => $questionEntities,
				"is_anonymous" => $isAnonymous,
				"type" => $type,
				"allows_multiple_answers" => $allowsMultipleAnswers,
				"allows_revoting" => $allowsRevoting,
				"shuffle_options" => $shuffleOptions,
				"allow_adding_options" => $allowAddingOptions,
				"hide_results_until_closes" => $hideResultsUntilCloses,
				"members_only" => $membersOnly,
				"country_codes" => $countryCodes,
				"correct_option_ids" => $correctOptionIds,
				"explanation" => $explanation,
				"explanation_parse_mode" => $explanationParseMode?->value,
				"explanation_entities" => $explanationEntities,
				"explanation_media" => $explanationMedia?->getAsArray(),
				"open_period" => $openPeriod,
				"close_date" => $closeDate,
				"is_closed" => $isClosed,
				"description" => $description,
				"description_parse_mode" => $descriptionParseMode?->value,
				"description_entities" => $descriptionEntities,
				"media" => $media?->getAsArray(),
				"disable_notification" => $disableNotification,
				"protect_content" => $protectContent,
				"allow_paid_broadcast" => $allowPaidBroadcast,
				"message_effect_id" => $messageEffectId,
				"reply_parameters" => $replyParameters?->getAsArray(),
				"reply_markup" => $replyMarkup?->getAsArray(),
			],
			headers: ["Content-Type" => "multipart/form-data"],
		);

		return new Objects\Message($response->getData());
	}

}
