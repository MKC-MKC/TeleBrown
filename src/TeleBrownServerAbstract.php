<?php /** @noinspection PhpUnused */

namespace Haikiri\TeleBrown;

use Haikiri\TeleBrown\Exceptions\TelegramMainException;

abstract class TeleBrownServerAbstract
{

	#	Brown
	protected string $url = "https://api.telegram.org/bot";
	protected string $token = "";
	protected static ?bool $debug = false;

	public function __construct(string $url, string $token, $debug = false)
	{
		$this->url = $url !== "" ? $url : $this->url;
		$this->token = $token;
		self::$debug = filter_var($debug, FILTER_VALIDATE_BOOLEAN);
	}

	/**
	 * Используй метод для установки URL-адреса API. Если не указать, используется основной сервер по умолчанию.
	 *
	 * @param string $url
	 * @return void
	 */
	public function setUrl(string $url): void
	{
		$this->url = $url;
	}

	/**
	 * Используй метод для получения URL-адреса API.
	 *
	 * @return string
	 */
	public function getUrl(): string
	{
		return $this->url;
	}

	/**
	 * Используй метод для записи токена.
	 *
	 * @param string $token
	 * @return void
	 */
	public function setToken(string $token): void
	{
		$this->token = $token;
	}

	/**
	 * Используй метод для получения токена.
	 *
	 * @return string
	 */
	public function getToken(): string
	{
		return $this->token;
	}

	/**
	 * Используй метод для получения ID твоего бота.
	 *
	 * @return string
	 */
	public function getBotId(): string
	{
		return strtok(string: $this->getToken(), token: ":") ?: "";
	}

	/**
	 * Простой метод для тестирования токена аутентификации вашего бота.
	 * Не требует параметров. Возвращает основную информацию о боте в виде объекта User.
	 *
	 * A simple method for testing your bot's authentication token.
	 * Requires no parameters. Returns basic information about the bot in form of a User object.
	 *
	 * @see https://core.telegram.org/bots/api#getme
	 *
	 * @return Objects\User
	 * @throws TelegramMainException
	 */
	public function getMe(): Objects\User
	{
		return new Objects\User(
			$this->sendRequest(method: __FUNCTION__)->getData()
		);
	}

	/**
	 * Используйте этот метод, чтобы получать входящие обновления с помощью долгого опроса (wiki). Возвращает массив объектов Update.
	 * Use this method to receive incoming updates using long polling (wiki). Returns an Array of Update objects.
	 *
	 * @param int|string|null $offset
	 * @param int|null $limit
	 * @param int|null $timeout
	 * @param Enums\UpdateEnum[]|null $allowedUpdates
	 * @return Objects\Update[]
	 * @throws TelegramMainException
	 */
	public function getUpdates(
		int|string|null $offset = null,
		int|null        $limit = null,
		int|null        $timeout = null,
		array|null      $allowedUpdates = null,
	): array
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"offset" => $offset,
				"limit" => $limit,
				"timeout" => $timeout,
				"allowed_updates" => $allowedUpdates ? array_map(fn($u) => $u->value, $allowedUpdates) : null,
			]
		);

		return array_map(fn(array $item): Objects\Update => new Objects\Update($item), $response->getData());
	}

	/**
	 * Используйте этот метод, чтобы установить URL-адрес webhook для вашего бота.
	 * Всякий раз, когда бот получает обновление, он отправляет его на указанный URL-адрес в виде POST-запроса с JSON-объектом Update в теле.
	 * В случае неудачного запроса (HTTP-код ответа, отличный от 2XY), мы повторим запрос и сдадимся после разумного количества попыток.
	 * Если вы хотите убедиться, что webhook был установлен вами, вы можете указать секретные данные в параметре secret_token.
	 * Если указано, запрос будет содержать заголовок "X-Telegram-Bot-Api-Secret-Token" с секретным token в качестве содержимого.
	 *
	 * Use this method to specify a URL and receive incoming updates via an outgoing webhook.
	 * Whenever there is an update for the bot, we will send an HTTPS POST request to the specified URL, containing a JSON-serialized Update.
	 * In case of an unsuccessful request (a request with response HTTP status code different from 2XY), we will repeat the request and give up after a reasonable amount of attempts.
	 * If you'd like to make sure that the webhook was set by you, you can specify secret data in the parameter secret_token.
	 * If specified, the request will contain a header “X-Telegram-Bot-Api-Secret-Token” with the secret token as content.
	 *
	 * Notes
	 * 1. You will not be able to receive updates using getUpdates for as long as an outgoing webhook is set up.
	 * 2. To use a self-signed certificate, you need to upload your public key certificate using certificate parameter. Please upload as InputFile, sending a String will not work.
	 * 3. Ports currently supported for webhooks: 443, 80, 88, 8443.
	 *
	 * If you're having any trouble setting up webhooks, please check out this amazing guide to webhooks.
	 * @see https://core.telegram.org/bots/api#setwebhook
	 * @throws TelegramMainException
	 */
	public function setWebhook(
		string     $url,
		mixed      $certificate = null,
		?string    $ipAddress = null,
		?int       $maxConnections = null,
		array|null $allowedUpdates = null,
		?bool      $dropPendingUpdates = null,
		?string    $secretToken = null
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"url" => $url,
				"certificate" => $certificate,
				"ip_address" => $ipAddress,
				"max_connections" => $maxConnections,
				"allowed_updates" => $allowedUpdates ? array_map(fn($u) => $u->value, $allowedUpdates) : null,
				"drop_pending_updates" => $dropPendingUpdates,
				"secret_token" => $secretToken
			]
		)->isSuccess();
	}

	/**
	 * Используйте этот метод, чтобы удалить webhook интеграцию, если вы решите вернуться к getUpdates.
	 * Use this method to remove webhook integration if you decide to switch back to getUpdates.
	 *
	 * @see https://core.telegram.org/bots/api#deletewebhook
	 * @param bool|null $dropPendingUpdates
	 * @return bool
	 * @throws TelegramMainException
	 */
	public function deleteWebhook(bool|null $dropPendingUpdates = null): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"drop_pending_updates" => $dropPendingUpdates,
			],
		)->isSuccess();
	}

	/**
	 * Используйте этот метод, чтобы получить информацию о текущем webhook.
	 * Describes the current status of a webhook.
	 *
	 * @see https://core.telegram.org/bots/api#getwebhookinfo
	 * @throws TelegramMainException
	 */
	public function getWebhookInfo(): Objects\WebhookInfo
	{
		return new Objects\WebhookInfo(
			$this->sendRequest(method: __FUNCTION__)->getData()
		);
	}

	/**
	 * Используйте этот метод, чтобы отправить текстовые сообщения.
	 * Use this method to send text messages.
	 *
	 * @see https://core.telegram.org/bots/api#sendmessage
	 *
	 * @param int|string $chatId
	 * @param string $text
	 * @param string|null $businessConnectionId
	 * @param Enums\ParseModeEnum|null $parseMode
	 * @param int|null $messageThreadId
	 * @param array|null $entities
	 * @param Objects\LinkPreviewOptions|null $linkPreviewOptions
	 * @param bool|null $disableNotification
	 * @param bool|null $protectContent
	 * @param bool|null $allowPaidBroadcast
	 * @param string|null $messageEffectId
	 * @param Objects\ReplyParameters|null $replyParameters
	 * @param null|Objects\InlineKeyboardMarkup|Objects\ReplyKeyboardMarkup|Objects\ReplyKeyboardRemove|Objects\ForceReply $replyMarkup
	 * @return Objects\Message
	 * @throws TelegramMainException
	 */
	public function sendMessage(
		int|string                                                                                                   $chatId,
		string                                                                                                       $text,
		?string                                                                                                      $businessConnectionId = null,
		?Enums\ParseModeEnum                                                                                         $parseMode = Enums\ParseModeEnum::HTML,
		?int                                                                                                         $messageThreadId = null,
		?array                                                                                                       $entities = null,
		?Objects\LinkPreviewOptions                                                                                  $linkPreviewOptions = null,
		?bool                                                                                                        $disableNotification = null,
		?bool                                                                                                        $protectContent = null,
		?bool                                                                                                        $allowPaidBroadcast = null,
		?string                                                                                                      $messageEffectId = null,
		?Objects\ReplyParameters                                                                                     $replyParameters = null,
		null|Objects\InlineKeyboardMarkup|Objects\ReplyKeyboardMarkup|Objects\ReplyKeyboardRemove|Objects\ForceReply $replyMarkup = null,
	): Objects\Message
	{
		return new Objects\Message(
			$this->sendRequest(
				method: __FUNCTION__,
				params: [
					"chat_id" => $chatId,
					"text" => $text,
					"business_connection_id" => $businessConnectionId,
					"parse_mode" => $parseMode?->value,
					"message_thread_id" => $messageThreadId,
					"entities" => $entities,
					"link_preview_options" => $linkPreviewOptions?->getAsArray(),
					"disable_notification" => $disableNotification,
					"protect_content" => $protectContent,
					"allow_paid_broadcast" => $allowPaidBroadcast,
					"message_effect_id" => $messageEffectId,
					"reply_parameters" => $replyParameters?->getAsArray(),
					"reply_markup" => $replyMarkup?->getAsArray(),
				]
			)->getData()
		);
	}

	/**
	 * Используйте этот метод, чтобы переслать сообщения любого типа.
	 * Сервисные сообщения и сообщения с защищенным контентом не могут быть пересланы.
	 *
	 * Use this method to forward messages of any kind.
	 * Service messages and messages with protected content can't be forwarded.
	 *
	 * @see https://core.telegram.org/bots/api#forwardmessage
	 *
	 * @param int|string $chatId
	 * @param int|string $fromChatId
	 * @param int $messageId
	 * @param int|null $messageThreadId
	 * @param int|null $videoStartTimestamp
	 * @param bool|null $disableNotification
	 * @param bool|null $protectContent
	 * @return Objects\Message
	 * @throws TelegramMainException
	 */
	public function forwardMessage(
		int|string $chatId,
		int|string $fromChatId,
		int        $messageId,
		?int       $messageThreadId = null,
		?int       $videoStartTimestamp = null,
		?bool      $disableNotification = null,
		?bool      $protectContent = null,
	): Objects\Message
	{
		return new Objects\Message(
			$this->sendRequest(
				method: __FUNCTION__,
				params: [
					"chat_id" => $chatId,
					"from_chat_id" => $fromChatId,
					"message_id" => $messageId,
					"message_thread_id" => $messageThreadId,
					"video_start_timestamp" => $videoStartTimestamp,
					"disable_notification" => $disableNotification,
					"protect_content" => $protectContent,
				]
			)->getData()
		);
	}

	/**
	 * Используйте этот метод, чтобы переслать несколько сообщений любого типа.
	 * Если некоторые из указанных сообщений не могут быть найдены или пересланы, они будут пропущены.
	 * Сервисные сообщения и сообщения с защищенным контентом не могут быть пересланы.
	 * Группировка альбомов сохраняется для пересланных сообщений.
	 * При успешном выполнении возвращается массив идентификаторов сообщений, которые были отправлены.
	 *
	 * Use this method to forward multiple messages of any kind.
	 * If some of the specified messages can't be found or forwarded, they are skipped.
	 * Service messages and messages with protected content can't be forwarded.
	 * Album grouping is kept for forwarded messages.
	 * On success, an array of MessageId of the sent messages is returned.
	 *
	 * @param int|string $chatId
	 * @param int|string $fromChatId
	 * @param array $messageIds
	 * @param int|null $messageThreadId
	 * @param bool|null $disableNotification
	 * @param bool|null $protectContent
	 * @return Objects\MessageId[]
	 * @throws TelegramMainException
	 */
	public function forwardMessages(
		int|string $chatId,
		int|string $fromChatId,
		array      $messageIds,
		?int       $messageThreadId = null,
		?bool      $disableNotification = null,
		?bool      $protectContent = null,
	): array
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"message_thread_id" => $messageThreadId,
				"from_chat_id" => $fromChatId,
				"message_ids" => $messageIds,
				"disable_notification" => $disableNotification,
				"protect_content" => $protectContent,
			]
		);

		return array_map(fn(array $item): Objects\MessageId => new Objects\MessageId($item), $response->getData());
	}

	/**
	 * Используйте этот метод, чтобы отправить контактные данные.
	 * Use this method to send phone contacts.
	 *
	 * @param int|string $chatId
	 * @param string $phoneNumber
	 * @param string $firstName
	 * @param string|null $lastName
	 * @param string|null $vcard
	 * @param int|null $messageThreadId
	 * @param bool|null $disableNotification
	 * @param bool|null $protectContent
	 * @param bool|null $allowPaidBroadcast
	 * @param string|null $messageEffectId
	 * @param Objects\ReplyParameters|null $replyParameters
	 * @param mixed|null $replyMarkup
	 * @return Objects\Message
	 * @throws TelegramMainException
	 */
	public function sendContact(
		int|string               $chatId,
		string                   $phoneNumber,
		string                   $firstName,
		?string                  $lastName = null,
		?string                  $vcard = null,
		?int                     $messageThreadId = null,
		?bool                    $disableNotification = null,
		?bool                    $protectContent = null,
		?bool                    $allowPaidBroadcast = null,
		?string                  $messageEffectId = null,
		?Objects\ReplyParameters $replyParameters = null,
		mixed                    $replyMarkup = null,
	): Objects\Message
	{
		return new Objects\Message(
			$this->sendRequest(
				method: __FUNCTION__,
				params: [
					"chat_id" => $chatId,
					"phone_number" => $phoneNumber,
					"first_name" => $firstName,
					"last_name" => $lastName,
					"vcard" => $vcard,
					"message_thread_id" => $messageThreadId,
					"disable_notification" => $disableNotification,
					"protect_content" => $protectContent,
					"allow_paid_broadcast" => $allowPaidBroadcast,
					"message_effect_id" => $messageEffectId,
					"reply_parameters" => $replyParameters?->getAsArray(),
					"reply_markup" => $replyMarkup?->getAsArray(),
				]
			)->getData()
		);
	}

	/**
	 * Используйте этот метод, если вам нужно сообщить пользователю, что что-то происходит на стороне бота.
	 * Статус устанавливается на 5 секунд или меньше (когда сообщение приходит от вашего бота, клиенты Telegram очищают его статус печати).
	 * Возвращает True в случае успеха.
	 *
	 * Use this method when you need to tell the user that something is happening on the bot's side.
	 * The status is set for 5 seconds or less (when a message arrives from your bot, Telegram clients clear its typing status).
	 * Returns True on success.
	 *
	 * @param int|string $chatId
	 * @param Enums\ActionEnum $action
	 * @param int|null $messageThreadId
	 * @param string|null $businessConnectionId
	 * @return bool
	 * @throws TelegramMainException
	 */
	public function sendChatAction(
		int|string       $chatId,
		Enums\ActionEnum $action = Enums\ActionEnum::TYPING,
		?int             $messageThreadId = null,
		?string          $businessConnectionId = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"action" => $action?->value,
				"message_thread_id" => $messageThreadId,
				"business_connection_id" => $businessConnectionId,
			]
		)->isSuccess();
	}

	/**
	 * Используйте этот метод, чтобы запретить пользователю в группе, супергруппе или канале.
	 * В случае супергрупп и каналов пользователь не сможет вернуться в чат самостоятельно, используя приглашения, и т.д., если его не разблокировать сначала.
	 * Бот должен быть администратором в чате, чтобы это работало, и должен иметь соответствующие права администратора.
	 * Возвращает True в случае успеха.
	 *
	 * Use this method to ban a user in a group, a supergroup or a channel.
	 * In the case of supergroups and channels, the user will not be able to return to the chat on their own using invite links, etc., unless unbanned first.
	 * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights.
	 * Returns True on success.
	 *
	 * @param int|string $chatId
	 * @param int $userId
	 * @param int|null $untilDate
	 * @param bool|null $revokeMessages
	 * @return bool
	 * @throws TelegramMainException
	 */
	public function banChatMember(
		int|string $chatId,
		int        $userId,
		?int       $untilDate = null,
		?bool      $revokeMessages = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"user_id" => $userId,
				"until_date" => $untilDate,
				"revoke_messages" => $revokeMessages,
			]
		)->isSuccess();
	}

	/**
	 * Неофициальный метод для кика пользователя из чата. Банит пользователя на 30 секунд, чтобы выполнить кик из чата.
	 * Метод не является частью официального API Telegram.
	 *
	 * @param int|string $chatId
	 * @param int $userId
	 * @param bool|null $revokeMessages
	 * @return bool
	 * @throws TelegramMainException
	 */
	public function kickChatMember(
		int|string $chatId,
		int        $userId,
		?bool      $revokeMessages = null,
	): bool
	{
		return $this->banChatMember(
			chatId: $chatId,
			userId: $userId,
			untilDate: time() + 30,
			revokeMessages: $revokeMessages
		);
	}

	/**
	 * Используйте этот метод, чтобы разблокировать ранее заблокированного пользователя в супергруппе или канале.
	 * Пользователь не вернется в группу или канал автоматически, но сможет присоединиться по ссылке и т.д.
	 * Бот должен быть администратором, чтобы это работало.
	 *
	 * Use this method to unban a previously banned user in a supergroup or channel.
	 * The user will not return to the group or channel automatically, but will be able to join via link, etc.
	 * The bot must be an administrator for this to work.
	 *
	 * @param int|string $chatId
	 * @param int $userId
	 * @param bool $onlyIfBanned
	 * @return bool
	 * @throws TelegramMainException
	 */
	public function unbanChatMember(
		int|string $chatId,
		int        $userId,
		bool       $onlyIfBanned = true,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"user_id" => $userId,
				"only_if_banned" => $onlyIfBanned,
			]
		)->isSuccess();
	}

	/**
	 * Используйте этот метод, чтобы ограничить пользователя в супергруппе.
	 * Бот должен быть администратором в супергруппе, чтобы это работало, и должен иметь соответствующие права администратора.
	 * Передайте True для всех разрешений, чтобы снять ограничения с пользователя.
	 * Возвращает True в случае успеха.
	 *
	 * Use this method to restrict a user in a supergroup.
	 * The bot must be an administrator in the supergroup for this to work and must have the appropriate administrator rights.
	 * Pass True for all permissions to lift restrictions from a user.
	 * Returns True on success.
	 *
	 * @param int|string $chatId
	 * @param int $userId
	 * @param Objects\ChatPermissions $permissions
	 * @param bool|null $useIndependentChatPermissions
	 * @param int|null $untilDate
	 * @return bool
	 * @throws TelegramMainException
	 */
	public function restrictChatMember(
		int|string              $chatId,
		int                     $userId,
		Objects\ChatPermissions $permissions,
		?bool                   $useIndependentChatPermissions = null,
		?int                    $untilDate = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"user_id" => $userId,
				"permissions" => $permissions->getAsArray(),
				"use_independent_chat_permissions" => $useIndependentChatPermissions,
				"until_date" => $untilDate,
			]
		)->isSuccess();
	}

	/**
	 * Используйте этот метод, чтобы изменить права администратора в супергруппе или канале.
	 * Бот должен быть администратором в чате, чтобы это работало, и должен иметь соответствующие права администратора.
	 * Передайте False для всех логических параметров, чтобы понизить пользователя.
	 * Возвращает True в случае успеха.
	 *
	 * Use this method to promote or demote a user in a supergroup or a channel.
	 * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights.
	 * Pass False for all boolean parameters to demote a user.
	 * Returns True on success.
	 *
	 * @param int|string $chatId
	 * @param int $userId
	 * @param bool|null $isAnonymous
	 * @param bool|null $canManageChat
	 * @param bool|null $canDeleteMessages
	 * @param bool|null $canManageVideoChats
	 * @param bool|null $canRestrictMembers
	 * @param bool|null $canPromoteMembers
	 * @param bool|null $canChangeInfo
	 * @param bool|null $canInviteUsers
	 * @param bool|null $canPostStories
	 * @param bool|null $canEditStories
	 * @param bool|null $canDeleteStories
	 * @param bool|null $canPostMessages
	 * @param bool|null $canEditMessages
	 * @param bool|null $canPinMessages
	 * @param bool|null $canManageTopics
	 * @return bool
	 * @throws TelegramMainException
	 */
	public function promoteChatMember(
		int|string $chatId,
		int        $userId,
		?bool      $isAnonymous = null,
		?bool      $canManageChat = null,
		?bool      $canDeleteMessages = null,
		?bool      $canManageVideoChats = null,
		?bool      $canRestrictMembers = null,
		?bool      $canPromoteMembers = null,
		?bool      $canChangeInfo = null,
		?bool      $canInviteUsers = null,
		?bool      $canPostStories = null,
		?bool      $canEditStories = null,
		?bool      $canDeleteStories = null,
		?bool      $canPostMessages = null,
		?bool      $canEditMessages = null,
		?bool      $canPinMessages = null,
		?bool      $canManageTopics = null
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"user_id" => $userId,
				"is_anonymous" => $isAnonymous,
				"can_manage_chat" => $canManageChat,
				"can_delete_messages" => $canDeleteMessages,
				"can_manage_video_chats" => $canManageVideoChats,
				"can_restrict_members" => $canRestrictMembers,
				"can_promote_members" => $canPromoteMembers,
				"can_change_info" => $canChangeInfo,
				"can_invite_users" => $canInviteUsers,
				"can_post_stories" => $canPostStories,
				"can_edit_stories" => $canEditStories,
				"can_delete_stories" => $canDeleteStories,
				"can_post_messages" => $canPostMessages,
				"can_edit_messages" => $canEditMessages,
				"can_pin_messages" => $canPinMessages,
				"can_manage_topics" => $canManageTopics
			]
		)->isSuccess();
	}

	/**
	 * Используйте этот метод, чтобы установить специальный заголовок для администратора в супергруппе, управляемой ботом.
	 * Use this method to set a custom title for an administrator in a supergroup promoted by the bot.
	 *
	 * @param int|string $chatId
	 * @param int $userId
	 * @param string $customTitle
	 * @return bool
	 * @throws TelegramMainException
	 */
	public function setChatAdministratorCustomTitle(
		int|string $chatId,
		int        $userId,
		string     $customTitle
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"user_id" => $userId,
				"custom_title" => $customTitle
			]
		)->isSuccess();
	}

	/**
	 * Используйте этот метод, чтобы заблокировать канал отправителя в супергруппе или канале.
	 * Пока чат не будет разблокирован, владелец заблокированного чата не сможет отправлять сообщения от имени любого из своих каналов.
	 * Бот должен быть администратором в супергруппе или канале, чтобы это работало, и должен иметь соответствующие права администратора.
	 *
	 * Use this method to ban a channel chat in a supergroup or a channel.
	 * Until the chat is unbanned, the owner of the banned chat won't be able to send messages on behalf any of their channels.
	 * The bot must be an administrator in the supergroup or channel for this to work and must have the appropriate administrator rights.
	 *
	 * @param int|string $chatId
	 * @param int $senderChatId
	 * @return bool
	 * @throws TelegramMainException
	 */
	public function banChatSenderChat(
		int|string $chatId,
		int        $senderChatId
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"sender_chat_id" => $senderChatId
			]
		)->isSuccess();
	}

	/**
	 * Используйте этот метод, чтобы разблокировать канал отправителя в супергруппе или канале.
	 * Бот должен быть администратором в супергруппе или канале, чтобы это работало, и должен иметь соответствующие права администратора.
	 *
	 * Use this method to unban a previously banned channel chat in a supergroup or channel.
	 * The bot must be an administrator for this to work and must have the appropriate administrator rights.
	 *
	 * @param int|string $chatId
	 * @param int $senderChatId
	 * @return bool
	 * @throws TelegramMainException
	 */
	public function unbanChatSenderChat(
		int|string $chatId,
		int        $senderChatId
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"sender_chat_id" => $senderChatId
			]
		)->isSuccess();
	}

	/**
	 * Используйте этот метод, чтобы установить разрешения для всех участников группы или супергруппы.
	 * Бот должен быть администратором в группе или супергруппе, чтобы это работало, и должен иметь права администратора can_restrict_members.
	 *
	 * Use this method to set default chat permissions for all members.
	 * The bot must be an administrator in the group or a supergroup for this to work and must have the can_restrict_members administrator rights.
	 *
	 * @param int|string $chatId
	 * @param Objects\ChatPermissions $permissions
	 * @param bool|null $useIndependentChatPermissions
	 * @return bool
	 * @throws TelegramMainException
	 */
	public function setChatPermissions(
		int|string              $chatId,
		Objects\ChatPermissions $permissions,
		?bool                   $useIndependentChatPermissions = null,
	): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"permissions" => $permissions->getAsArray(),
				"use_independent_chat_permissions" => $useIndependentChatPermissions,
			]
		)->isSuccess();
	}

	/**
	 * Используйте этот метод, чтобы ваш бот мог покинуть группу, супергруппу или канал.
	 * Use this method for your bot to leave a group, supergroup or channel.
	 *
	 * @param int|string $chatId
	 * @return bool
	 * @throws TelegramMainException
	 */
	public function leaveChat(int|string $chatId): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
			]
		)->isSuccess();
	}

	/**
	 * Используйте этот метод, чтобы получить количество участников в чате.
	 * Use this method to get the number of members in a chat.
	 *
	 * @param int|string $chatId
	 * @return int
	 * @throws TelegramMainException
	 */
	public function getChatMemberCount(int|string $chatId): int
	{
		return (int)$this->sendRequest(method: __FUNCTION__, params: ["chat_id" => $chatId]) ?? 0;
	}

	/**
	 * Используйте этот метод, чтобы редактировать текст и сообщения игры.
	 * На успех, если отредактированное сообщение не является встроенным сообщением, возвращается отредактированное сообщение, в противном случае возвращается True.
	 * Обратите внимание, что бизнес-сообщения, которые не были отправлены ботом и не содержат встроенной клавиатуры, могут быть отредактированы только в течение 48 часов с момента их отправки.
	 *
	 * Use this method to edit text and game messages.
	 * On success, if the edited message is not an inline message, the edited Message is returned, otherwise True is returned.
	 * Note that business messages that were not sent by the bot and do not contain an inline keyboard can only be edited within 48 hours from the time they were sent.
	 *
	 * @see https://core.telegram.org/bots/api#editmessagetext
	 *
	 * @param int|string $chatId
	 * @param int|string $messageId
	 * @param string $text
	 * @param string|null $businessConnectionId
	 * @param string|null $inlineMessageId
	 * @param Enums\ParseModeEnum|null $parseMode
	 * @param array|null $entities
	 * @param Objects\LinkPreviewOptions|null $linkPreviewOptions
	 * @param null|Objects\InlineKeyboardMarkup $replyMarkup
	 * @return Objects\Message
	 * @throws TelegramMainException
	 */
	public function editMessageText(
		int|string                  $chatId,
		int|string                  $messageId,
		string                      $text,
		?string                     $businessConnectionId = null,
		?string                     $inlineMessageId = null,
		?Enums\ParseModeEnum        $parseMode = Enums\ParseModeEnum::HTML,
		?array                      $entities = null,
		?Objects\LinkPreviewOptions $linkPreviewOptions = null,
		mixed                       $replyMarkup = null
	): Objects\Message
	{
		return new Objects\Message(
			$this->sendRequest(
				method: __FUNCTION__,
				params: [
					"chat_id" => $chatId,
					"message_id" => $messageId,
					"text" => $text,
					"business_connection_id" => $businessConnectionId,
					"inline_message_id" => $inlineMessageId,
					"parse_mode" => $parseMode?->value,
					"entities" => $entities,
					"link_preview_options" => $linkPreviewOptions?->getAsArray(),
					"reply_markup" => $replyMarkup?->getAsArray(),
				]
			)->getData()
		);
	}

	/**
	 * Используйте этот метод, чтобы удалить сообщение.
	 * Use this method to delete a message.
	 *
	 * @see https://core.telegram.org/bots/api#deletemessage
	 *
	 * @param int|string $chatId
	 * @param int $messageId
	 * @return bool
	 * @throws TelegramMainException
	 */
	public function deleteMessage(int|string $chatId, int $messageId): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"message_id" => $messageId,
			]
		)->isSuccess();
	}

	/**
	 * Используйте этот метод, чтобы удалить несколько сообщений одновременно.
	 * Если некоторые из указанных сообщений не могут быть найдены, они будут пропущены.
	 *
	 * Use this method to delete multiple messages simultaneously.
	 * If some of the specified messages can't be found, they are skipped.
	 *
	 * @param int|string $chatId
	 * @param array $messageId
	 * @return bool
	 * @throws TelegramMainException
	 */
	public function deleteMessages(int|string $chatId, array $messageId): bool
	{
		return $this->sendRequest(
			method: __FUNCTION__,
			params: [
				"chat_id" => $chatId,
				"message_ids" => $messageId,
			]
		)->isSuccess();
	}

}
