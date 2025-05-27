<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * WebhookInfo – Describes the current status of a webhook.
 * @see https://core.telegram.org/bots/api#webhookinfo
 */
class WebhookInfo extends ResponseWrapper
{

	public function getUrl(): string
	{
		return (string)$this->getData("url");
	}

	public function hasCustomCertificate(): bool
	{
		return (bool)$this->getData("has_custom_certificate");
	}

	public function getPendingUpdateCount(): int
	{
		return (int)$this->getData("pending_update_count");
	}

	public function getIpAddress(): string
	{
		return (string)$this->getData("ip_address");
	}

	public function getLastErrorDate(): int
	{
		return (int)$this->getData("last_error_date");
	}

	public function getLastErrorMessage(): string
	{
		return (string)$this->getData("last_error_message");
	}

	public function getLastSynchronizationErrorDate(): int
	{
		return (int)$this->getData("last_synchronization_error_date");
	}

	public function getMaxConnections(): int
	{
		return (int)$this->getData("max_connections");
	}

	public function getAllowedUpdates(): array
	{
		return (array)$this->getData("allowed_updates");
	}

}
