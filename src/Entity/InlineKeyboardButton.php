<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Entity;

use Haikiri\TeleBrown\Type;

/**
 * InlineKeyboardButton – This object represents one button of an inline keyboard. Exactly one of the optional fields must be used to specify type of the button.
 * @see https://core.telegram.org/bots/api#inlinekeyboardbutton
 */
class InlineKeyboardButton extends Type
{

	public function __construct(array|null $response)
	{
		$this->response = $response;
	}

	public function getAsArray(): array|null
	{
		return $this->response ?? null;
	}

	public function getText(): ?string
	{
		return (string)$this->getData("text") ?? null;
	}

	public function getUrl(): ?string
	{
		return (string)$this->getData("url") ?? null;
	}

	public function getCallbackData(): ?string
	{
		return (string)$this->getData("callback_data") ?? null;
	}

	public function getWebApp(): ?WebAppInfo
	{
		return ($data = $this->getData("web_app")) && is_array($data) ? new WebAppInfo($data) : null;
	}

	public function getLoginUrl(): ?LoginUrl
	{
		return ($data = $this->getData("login_url")) && is_array($data) ? new LoginUrl($data) : null;
	}

	public function getSwitchInlineQuery(): ?string
	{
		return (string)$this->getData("switch_inline_query") ?? null;
	}

	public function getSwitchInlineQueryCurrentChat(): ?string
	{
		return (string)$this->getData("switch_inline_query_current_chat") ?? null;
	}

	public function getSwitchInlineQueryChosenChat(): ?SwitchInlineQueryChosenChat
	{
		return ($data = $this->getData("switch_inline_query_chosen_chat")) && is_array($data) ? new SwitchInlineQueryChosenChat($data) : null;
	}

	public function getCopyText(): ?CopyTextButton
	{
		return ($data = $this->getData("copy_text")) && is_array($data) ? new CopyTextButton($data) : null;
	}

	public function getCallbackGame(): array
	{
		return $this->getData("callback_game") ?? [];
	}

	public function isPay(): ?bool
	{
		return (bool)$this->getData("pay") ?? null;
	}

}
