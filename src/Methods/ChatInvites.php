<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Exceptions\TelegramMainException;
use Haikiri\TeleBrown\Objects;

trait ChatInvites
{

	/**
	 * Создаём новую основную пригласительную ссылку чата, отзывая предыдущую.
	 * Бот должен быть администратором с соответствующими правами.
	 * Боты могут использовать только собственные пригласительные ссылки.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя @username.
	 * @return string
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#exportchatinvitelink
	 */
	public function exportChatInviteLink(
		int|string $chatId,
	): string
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
			],
		);

		return $response->getData();
	}

	/**
	 * Одобряем заявку на вступление в чат.
	 * Боту требуется право администратора can_invite_users.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя @username.
	 * @param int $userId Уникальный идентификатор пользователя, например 123456789.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#approvechatjoinrequest
	 */
	public function approveChatJoinRequest(
		int|string $chatId,
		int        $userId,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"user_id" => $userId,
			],
		)->isSuccess();
	}

	/**
	 * Отклоняем заявку на вступление в чат.
	 * Боту требуется право администратора can_invite_users.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя @username.
	 * @param int $userId Уникальный идентификатор пользователя, например 123456789.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#declinechatjoinrequest
	 */
	public function declineChatJoinRequest(
		int|string $chatId,
		int        $userId,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"user_id" => $userId,
			],
		)->isSuccess();
	}

	/**
	 * Обрабатываем запрос на вступление в чат.
	 * При успешном выполнении возвращается true.
	 *
	 * @param string $chatJoinRequestQueryId Уникальный идентификатор запроса на вступление.
	 * @param string $result Решение: approve - одобрить, decline - отклонить, queue - оставить другим администраторам.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#answerchatjoinrequestquery
	 */
	public function answerChatJoinRequestQuery(
		string $chatJoinRequestQueryId,
		string $result,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_join_request_query_id" => $chatJoinRequestQueryId,
				"result" => $result,
			],
		)->isSuccess();
	}

	/**
	 * Показываем пользователю Mini App перед решением по запросу на вступление.
	 * Для завершения запроса после взаимодействия с Mini App используем answerChatJoinRequestQuery.
	 *
	 * @param string $chatJoinRequestQueryId Уникальный идентификатор запроса на вступление.
	 * @param string $webAppUrl HTTPS-адрес Mini App, открываемого с дополнительными данными.
	 * @return bool true при успешном выполнении.
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#sendchatjoinrequestwebapp
	 */
	public function sendChatJoinRequestWebApp(
		string $chatJoinRequestQueryId,
		string $webAppUrl,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_join_request_query_id" => $chatJoinRequestQueryId,
				"web_app_url" => $webAppUrl,
			],
		)->isSuccess();
	}

	/**
	 * Отзываем пригласительную ссылку, созданную ботом.
	 * При отзыве основной ссылки автоматически создаётся новая.
	 * Бот должен быть администратором с соответствующими правами.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя @username.
	 * @param string $inviteLink Пригласительная ссылка чата, например https://t.me/+example.
	 * @return Objects\ChatInviteLink
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#revokechatinvitelink
	 */
	public function revokeChatInviteLink(
		int|string $chatId,
		string     $inviteLink,
	): Objects\ChatInviteLink
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"invite_link" => $inviteLink,
			],
		);

		return new Objects\ChatInviteLink($response->getData());
	}

	/**
	 * Создаём пригласительную ссылку с платной подпиской на канал.
	 * Боту требуется право администратора can_invite_users.
	 * Ссылку можно изменить через editChatSubscriptionInviteLink или отозвать через revokeChatInviteLink.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя @username.
	 * @param int $subscriptionPeriod Период подписки в секундах. Сейчас допускается только 2592000 (30 дней).
	 * @param int $subscriptionPrice Стоимость подписки в Telegram Stars за каждый период, от 1 до 10000.
	 * @param string|null $name Название пригласительной ссылки, от 0 до 32 символов.
	 * @return Objects\ChatInviteLink
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#createchatsubscriptioninvitelink
	 */
	public function createChatSubscriptionInviteLink(
		int|string  $chatId,
		int         $subscriptionPeriod,
		int         $subscriptionPrice,
		string|null $name = null,
	): Objects\ChatInviteLink
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"subscription_period" => $subscriptionPeriod,
				"subscription_price" => $subscriptionPrice,
				"name" => $name,
			],
		);

		return new Objects\ChatInviteLink($response->getData());
	}

	/**
	 * Изменяем созданную ботом пригласительную ссылку с подпиской.
	 * Боту требуется право администратора can_invite_users.
	 *
	 * @param int|string $chatId ID чата, например -1001234567890, или имя @username.
	 * @param string $inviteLink Пригласительная ссылка чата, например https://t.me/+example.
	 * @param string|null $name Название пригласительной ссылки, от 0 до 32 символов.
	 * @return Objects\ChatInviteLink
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#editchatsubscriptioninvitelink
	 */
	public function editChatSubscriptionInviteLink(
		int|string  $chatId,
		string      $inviteLink,
		string|null $name = null,
	): Objects\ChatInviteLink
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"invite_link" => $inviteLink,
				"name" => $name,
			],
		);

		return new Objects\ChatInviteLink($response->getData());
	}

}
