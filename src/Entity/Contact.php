<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * Contact – This object represents a phone contact.
 * @see https://core.telegram.org/bots/api#contact
 */
class Contact
{
	private array $response;

	public function __construct(array $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array
	{
		return $this->response ?? [];
	}

	/**
	 * Optional. Contact's user identifier in Telegram.
	 * This number may have more than 32 significant bits and some programming languages
	 * may have difficulty/silent defects in interpreting it.
	 * But it has at most 52 significant bits,
	 * so a 64-bit integer or double-precision float type are safe for storing this identifier.
	 *
	 * @return int
	 */
	public function getId(): int
	{
		return (int)$this->getAsArray()["user_id"] ?? 0;
	}

	/**
	 * Contact's phone number
	 *
	 * @return string
	 */
	public function getPhoneNumber(): string
	{
		return (string)$this->getAsArray()["phone_number"] ?? "";
	}

	/**
	 * Contact's first name
	 *
	 * @return string
	 */
	public function getFirstName(): string
	{
		return (string)$this->getAsArray()["first_name"] ?? "";
	}

	/**
	 * Optional. Contact's last name
	 *
	 * @return string
	 */
	public function getLastName(): string
	{
		return (string)$this->getAsArray()["last_name"] ?? "";
	}

	/**
	 * Optional. Additional data about the contact in the form of a vCard
	 *
	 * @return string
	 */
	public function getVCard(): string
	{
		return (string)$this->getAsArray()["vcard"] ?? "";
	}

}
