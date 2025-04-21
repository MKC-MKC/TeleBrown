<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

/**
 * WebhookInfo – Describes the current status of a webhook.
 * @see https://core.telegram.org/bots/api#webhookinfo
 */
class WebhookInfo
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

	public function getUrl(): string
	{
		return (string)$this->getAsArray()["url"] ?? "";
	}

	public function hasCustomCertificate(): bool
	{
		return ($this->getAsArray()["has_custom_certificate"] ?? false);
	}

	public function getPendingUpdateCount(): int
	{
		return (int)($this->getAsArray()["pending_update_count"] ?? 0);
	}

	public function getIpAddress(): ?string
	{
		return $this->getAsArray()["ip_address"] ?? null;
	}

	public function getLastErrorDate(): ?int
	{
		return $this->getAsArray()["last_error_date"] ?? null;
	}

	public function getLastErrorMessage(): ?string
	{
		return $this->getAsArray()["last_error_message"] ?? null;
	}

	public function getLastSynchronizationErrorDate(): ?int
	{
		return $this->getAsArray()["last_synchronization_error_date"] ?? null;
	}

	public function getMaxConnections(): ?int
	{
		return $this->getAsArray()["max_connections"] ?? null;
	}

	public function getAllowedUpdates(): ?array
	{
		return $this->getAsArray()["allowed_updates"] ?? null;
	}

}
