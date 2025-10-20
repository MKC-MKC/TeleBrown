<?php

namespace Haikiri\TeleBrown;

class Response
{

	private function __construct(
		private readonly bool   $success,
		private readonly int    $code,
		private readonly string $message,
		private readonly mixed  $data,
		private readonly mixed  $raw,
	)
	{
	}

	public static function fromResponse(array $response): self
	{
		return new self(
			success: (bool)($response["ok"] ?? false),
			code: (int)($response["error_code"] ?? -1),
			message: (string)($response["description"] ?? "N/A"),
			data: is_array($response["result"] ?? null) ? $response["result"] : [],
			raw: $response,
		);
	}

	public function isSuccess(): bool
	{
		return $this->success;
	}

	public function getCode(): int
	{
		return $this->code;
	}

	public function getMessage(): string
	{
		return $this->message;
	}

	public function getRaw(): mixed
	{
		return $this->raw;
	}

	public function getData(): mixed
	{
		return $this->data;
	}

}
