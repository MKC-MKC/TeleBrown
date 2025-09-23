<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * MaskPosition – This object describes the position on faces where a mask should be placed by default.
 * @see https://core.telegram.org/bots/api#maskposition
 */
class MaskPosition extends ResponseWrapper
{

	/**
	 * Часть лица, относительно которой должна быть размещена маска. Одна из «forehead», «eyes», «mouth» или «chin».
	 * The part of the face relative to which the mask should be placed. One of “forehead”, “eyes”, “mouth”, or “chin”.
	 *
	 * @return string
	 */
	public function getPoint(): string
	{
		return (string)$this->getData("point");
	}

	/**
	 * Смещение по оси X, измеренное в ширинах маски, масштабированных до размера лица, слева направо.
	 * К примеру, выбор -1.0 поместит маску слева от положения маски по умолчанию.
	 *
	 * Shift by X-axis measured in widths of the mask scaled to the face size, from left to right.
	 * For example, choosing -1.0 will place mask just to the left of the default mask position.
	 *
	 * @return float
	 */
	public function getXShift(): float
	{
		return (float)$this->getData("x_shift");
	}

	/**
	 * Смещение по оси Y, измеренное в высотах маски, масштабированных до размера лица, сверху вниз.
	 * Например, 1.0 поместит маску прямо под положение маски по умолчанию.
	 *
	 * Shift by Y-axis measured in heights of the mask scaled to the face size, from top to bottom.
	 * For example, 1.0 will place the mask just below the default mask position.
	 *
	 * @return float
	 */
	public function getYShift(): float
	{
		return (float)$this->getData("y_shift");
	}

	/**
	 * Коэффициент масштабирования маски. Например, 2.0 означает двойной размер.
	 * Mask scaling coefficient. For example, 2.0 means double size.
	 *
	 * @return float
	 */
	public function getScale(): float
	{
		return (float)$this->getData("scale");
	}

}
