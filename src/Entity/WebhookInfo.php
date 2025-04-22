<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * WebhookInfo – Describes the current status of a webhook.
 * @see https://core.telegram.org/bots/api#webhookinfo
 */
class WebhookInfo extends Type
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	public function getUrl(): string
	{
		return (string)$this->getData("url") ?? "";
	}

	public function hasCustomCertificate(): bool
	{
		return ($this->getData("has_custom_certificate") ?? false);
	}

	public function getPendingUpdateCount(): int
	{
		return (int)($this->getData("pending_update_count") ?? 0);
	}

	public function getIpAddress(): ?string
	{
		return $this->getData("ip_address") ?? null;
	}

	public function getLastErrorDate(): ?int
	{
		return $this->getData("last_error_date") ?? null;
	}

	public function getLastErrorMessage(): ?string
	{
		return $this->getData("last_error_message") ?? null;
	}

	public function getLastSynchronizationErrorDate(): ?int
	{
		return $this->getData("last_synchronization_error_date") ?? null;
	}

	public function getMaxConnections(): ?int
	{
		return $this->getData("max_connections") ?? null;
	}

	public function getAllowedUpdates(): ?array
	{
		return $this->getData("allowed_updates") ?? null;
	}

}
