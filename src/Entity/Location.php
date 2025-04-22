<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * Location – This object represents a point on the map.
 * @see https://core.telegram.org/bots/api#location
 */
class Location extends Type
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	/**
	 * Широта, определенная отправителем
	 * Latitude as defined by the sender
	 *
	 * @return float
	 */
	public function getLatitude(): float
	{
		return (float)$this->getData("latitude") ?? 0.0;
	}

	/**
	 * Долгота, определенная отправителем
	 * Longitude as defined by the sender
	 *
	 * @return float
	 */
	public function getLongitude(): float
	{
		return (float)$this->getData("longitude") ?? 0.0;
	}

	/**
	 * Опционально. Радиус неопределенности для местоположения, измеренный в метрах; 0-1500
	 * Optional. The radius of uncertainty for the location, measured in meters; 0-1500
	 *
	 * @return float
	 */
	public function getHorizontalAccuracy(): float
	{
		return (float)$this->getData("horizontal_accuracy") ?? 0.0;
	}

	/**
	 * Опционально. Время относительно даты отправки сообщения, в течение которого местоположение может быть обновлено; в секундах. Только для активных живых местоположений.
	 * Optional. Time relative to the message sending date, during which the location can be updated; in seconds. For active live locations only.
	 *
	 * @return int
	 */
	public function getLivePeriod(): int
	{
		return (int)$this->getData("live_period") ?? 0;
	}

	/**
	 * Опционально. Направление, в котором движется пользователь, в градусах; 1-360. Только для активных живых местоположений.
	 * Optional. The direction in which user is moving, in degrees; 1-360. For active live locations only.
	 *
	 * @return int
	 */
	public function getHeading(): int
	{
		return (int)$this->getData("heading") ?? 0;
	}

	/**
	 * Опционально. Максимальное расстояние для предупреждений о приближении к другому участнику чата, в метрах. Только для отправленных живых местоположений.
	 * Optional. The maximum distance for proximity alerts about approaching another chat member, in meters. For sent live locations only.
	 *
	 * @return int
	 */
	public function getProximityAlertRadius(): int
	{
		return (int)$this->getData("proximity_alert_radius") ?? 0;
	}

}
