<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Methods;

use Haikiri\TeleBrown\Exceptions\TelegramMainException;

trait BotSession
{

	/**
	 * Выходит из облачного сервера Bot API перед запуском бота на локальном сервере.
	 * Без выхода получение обновлений локальным сервером не гарантируется.
	 * После успешного вызова можно сразу войти на локальном сервере,
	 * но повторный вход в облачный сервер недоступен в течение 10 минут.
	 * При успешном выполнении возвращается True.
	 *
	 * @return bool
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#logout
	 */
	public function logOut(): bool
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
			],
		);

		return $response->isSuccess();
	}

	/**
	 * Закрывает экземпляр бота перед переносом с одного локального сервера на другой.
	 * Перед вызовом нужно удалить webhook, чтобы бот не запустился вновь после перезапуска сервера.
	 * В первые 10 минут после запуска бота метод возвращает ошибку 429.
	 * При успешном выполнении возвращается True.
	 *
	 * @return bool
	 * @throws TelegramMainException
	 * @see https://core.telegram.org/bots/api#close
	 */
	public function close(): bool
	{
		$response = $this->sendRequest(
			method: __FUNCTION__,
			params: [
			],
		);

		return $response->isSuccess();
	}

}
