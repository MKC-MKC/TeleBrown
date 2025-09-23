<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * WebAppInfo – Describes a Web App.
 * @see https://core.telegram.org/bots/api#webappinfo
 */
class WebAppInfo extends ResponseWrapper
{

	/**
	 * HTTPS ссылка на веб-приложение, которое будет открыто с дополнительными данными, как указано в разделе Инициализация веб-приложений
	 * An HTTPS URL of a Web App to be opened with additional data as specified in Initializing Web Apps
	 * @see https://core.telegram.org/bots/webapps#initializing-mini-apps
	 *
	 * @return string
	 */
	public function getUrl(): string
	{
		return (string)$this->getData("url");
	}

}
