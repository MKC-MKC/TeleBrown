<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * Location – This object represents a point on the map.
 * @see https://core.telegram.org/bots/api#location
 */
class Location extends ResponseWrapper
{

	/**
	 * Широта, определенная отправителем
	 * Latitude as defined by the sender
	 *
	 * @return float
	 */
	public function getLatitude(): float
	{
		return (float)$this->getData("latitude");
	}

	/**
	 * Долгота, определенная отправителем
	 * Longitude as defined by the sender
	 *
	 * @return float
	 */
	public function getLongitude(): float
	{
		return (float)$this->getData("longitude");
	}

	/**
	 * Опционально. Радиус неопределенности для местоположения, измеренный в метрах; 0-1500
	 * Optional. The radius of uncertainty for the location, measured in meters; 0-1500
	 *
	 * @return float
	 */
	public function getHorizontalAccuracy(): float
	{
		return (float)$this->getData("horizontal_accuracy");
	}

	/**
	 * Опционально. Время относительно даты отправки сообщения, в течение которого местоположение может быть обновлено; в секундах. Только для активных живых местоположений.
	 * Optional. Time relative to the message sending date, during which the location can be updated; in seconds. For active live locations only.
	 *
	 * @return int
	 */
	public function getLivePeriod(): int
	{
		return (int)$this->getData("live_period");
	}

	/**
	 * Опционально. Направление, в котором движется пользователь, в градусах; 1-360. Только для активных живых местоположений.
	 * Optional. The direction in which user is moving, in degrees; 1-360. For active live locations only.
	 *
	 * @return int
	 */
	public function getHeading(): int
	{
		return (int)$this->getData("heading");
	}

	/**
	 * Опционально. Максимальное расстояние для предупреждений о приближении к другому участнику чата, в метрах. Только для отправленных живых местоположений.
	 * Optional. The maximum distance for proximity alerts about approaching another chat member, in meters. For sent live locations only.
	 *
	 * @return int
	 */
	public function getProximityAlertRadius(): int
	{
		return (int)$this->getData("proximity_alert_radius");
	}

}
