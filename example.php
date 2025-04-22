<?php

require "vendor/autoload.php";

use Haikiri\TeleBrown;
use Haikiri\TeleBrown\Enums;
use Haikiri\TeleBrown\Entity;

$client = new TeleBrown\TeleBrownClient();
$server = new TeleBrown\TeleBrownServer();
$client::$debug = false;
$server::$debug = true;
//$server->setUrl("https://telegram.example.com/bot");
$server->setToken("6626819710:AAHuvytf9QbZHnxj8PKR7s3S0m82zmc27ac");
$thisFileUrl = (($_SERVER["HTTP_X_FORWARDED_PROTO"] ?? "") === "https" ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$chatId = "7174876173";

try {

	if (0) {
		echo "<h3>Подключение Webhooks интеграции</h3>";
		$setWebhook = $server->setWebhook(
			url: $thisFileUrl,
			maxConnections: 100,
		);
		echo $setWebhook
			? "Webhook установлен"
			: "Ошибка установки Webhook";
	}

	if (0) {
		echo "<h3>Удаление Webhooks интеграции</h3>";
		$deleteWebhook = $server->deleteWebhook(dropPendingUpdates: true);
		echo $deleteWebhook
			? "Webhook удален"
			: "Ошибка удаления Webhook";
	}

	if (0) {
		echo "<h3>Получение Webhooks информации</h3>";
		$webhookInfo = $server->getWebhookInfo();
		if ($webhookInfo->getUrl()) {
			echo "URL: {$webhookInfo->getUrl()}" . "<br>";
			echo "Имеет пользовательский сертификат: " . ($webhookInfo->hasCustomCertificate() ? "Да" : "Нет") . "<br>";
			echo "Количество ожидающих обновлений: {$webhookInfo->getPendingUpdateCount()}" . "<br>";
			echo "IP адрес: {$webhookInfo->getIpAddress()}" . "<br>";
			echo "Максимальное количество подключений: {$webhookInfo->getMaxConnections()}" . "<br>";
			echo "Разрешенные обновления: " . ($webhookInfo->getAllowedUpdates() ? implode(", ", $webhookInfo->getAllowedUpdates()) : "Нет") . "<br>";
			echo "Дата последней ошибки: " . ($webhookInfo->getLastErrorDate() ? date("d.m.Y H:i:s", $webhookInfo->getLastErrorDate()) : "Нет") . "<br>";
			echo "Сообщение последней ошибки: {$webhookInfo->getLastErrorMessage()}" . "<br>";
			echo "Дата последней синхронизации ошибки: " . ($webhookInfo->getLastSynchronizationErrorDate() ? date("d.m.Y H:i:s", $webhookInfo->getLastSynchronizationErrorDate()) : "Нет") . "<br>";
		} else {
			echo "Webhook не установлен";
		}
		echo "<pre>" . print_r($webhookInfo->getAsArray(), true) . "</pre>";
	}

	if (0) {
		echo "<h3>Отправка действия бота</h3>";
		$result = $server->sendChatAction(
			chatId: $chatId,
			action: Enums\ActionEnum::RECORD_VIDEO_NOTE,
		);
		echo $result
			? "Действие отправлено"
			: "Ошибка отправки действия";
	}

	if (0) {
		echo "<h3>Информация о боте</h3>";
		$me = $server->getMe();
		echo "ID: {$me->getId()}" . "<br>";
		echo "Является ботом: " . ($me->isBot() ? "Да" : "Нет") . "<br>";
		echo "Первое имя: {$me->getFirstName()}" . "<br>";
		echo "Username: {$me->getUsername()}" . "<br>";
		echo "Может присоединяться к группам: " . ($me->canJoinGroups() ? "Да" : "Нет") . "<br>";
		echo "Может читать все сообщения в группах: " . ($me->canReadAllGroupMessages() ? "Да" : "Нет") . "<br>";
		echo "Поддерживает inline запросы: " . ($me->supportsInlineQueries() ? "Да" : "Нет") . "<br>";
		echo "Может подключаться к бизнесу: " . ($me->canConnectToBusiness() ? "Да" : "Нет") . "<br>";
		echo "Имеет основное веб-приложение: " . ($me->hasMainWebApp() ? "Да" : "Нет") . "<br>";
//		var_dump($me);
	}

	$message = null;
	if (0) {
		echo "<h3>Отправка сообщения</h3>";
		$message = $server->sendMessage(
			chatId: $chatId,
			text: "Visit the https://core.telegram.org",
			linkPreviewOptions: new Entity\LinkPreviewOptions(["is_disabled" => true]),
		);
		var_dump($message);
	}

	if (0) {
		echo "<h3>Удаление сообщения</h3>";
		sleep(3);
		$result = $server->deleteMessage(
			chatId: $chatId,
			messageId: $message->getId(),
		);
		echo $result
			? "Сообщение удалено"
			: "Ошибка удаления сообщения";
	}

	if (0) {
		echo "<br><code>Working...</code><br>";

		$client->setUpdates();
		$type = $client->getUpdate()->getType();
		switch ($type) {
			case Enums\UpdateEnum::MESSAGE:
				echo "<h3>Получено сообщение</h3>";
				$message = $client->getUpdate()->getMessage();

				$server->sendMessage(
					chatId: $message->getChat()->getId(),
					text: "Вы написали сообщение:\n{$message->getText()}" . str_repeat(PHP_EOL, 2) .
					"ID: {$message->getId()}\n" .
					"Chat ID: {$message->getChat()->getId()}\n" .
					"Username: {$message->getFrom()->getUsername()}\n",
				);
				break;
			case Enums\UpdateEnum::EDITED_MESSAGE:
				echo "<h3>Получено редактированное сообщение</h3>";
				$message = $client->getUpdate()->getEditedMessage();
				$server->sendMessage(
					chatId: $message->getChat()->getId(),
					text: "Вы изменили сообщение:\n{$message->getText()}" . str_repeat(PHP_EOL, 2) .
					"ID: {$message->getId()}\n" .
					"Chat ID: {$message->getChat()->getId()}\n" .
					"Username: {$message->getFrom()->getUsername()}\n",
				);
				break;
			default:
				$server->sendMessage(
					chatId: $client->getUpdate()->getChat()->getId(), # Получаем актуальный ID из объекта чата.
					text: "Неизвестный тип обновления: <code>`$type?->value`</code>",
					replyParameters: new Entity\ReplyParameters([
						"message_id" => $client->getUpdate()->getActualMessage()->getId(), # Получаем ID сообщения на которое отвечаем.
					]),
				);
		}
	}

} catch (Throwable $e) {
	echo "Error: {$e->getMessage()}<br>";
	echo "Code: {$e->getCode()}<br>";
	echo "File: {$e->getFile()}<br>";
	echo "Line: {$e->getLine()}<br>";
	echo "Trace:<br>{$e->getTraceAsString()}<br>";
}
