<?php

declare(strict_types=1);

namespace Haikiri\TeleBrown\Objects;

use Haikiri\TeleBrown\ResponseWrapper;

/**
 * InlineKeyboardButton – This object represents one button of an inline keyboard. Exactly one of the optional fields must be used to specify type of the button.
 * @see https://core.telegram.org/bots/api#inlinekeyboardbutton
 */
class InlineKeyboardButton extends ResponseWrapper
{

	public function getText(): string
	{
		return (string)$this->getData("text");
	}

	public function getUrl(): string
	{
		return (string)$this->getData("url");
	}

	public function getCallbackData(): string
	{
		return (string)$this->getData("callback_data");
	}

	public function getWebApp(): WebAppInfo
	{
		$data = (array)$this->getData("web_app", []);
		return new WebAppInfo($data);
	}

	public function getLoginUrl(): LoginUrl
	{
		$data = (array)$this->getData("login_url", []);
		return new LoginUrl($data);
	}

	public function getSwitchInlineQuery(): string
	{
		return (string)$this->getData("switch_inline_query");
	}

	public function getSwitchInlineQueryCurrentChat(): string
	{
		return (string)$this->getData("switch_inline_query_current_chat");
	}

	public function getSwitchInlineQueryChosenChat(): SwitchInlineQueryChosenChat
	{
		$data = (array)$this->getData("switch_inline_query_chosen_chat", []);
		return new SwitchInlineQueryChosenChat($data);
	}

	public function getCopyText(): CopyTextButton
	{
		$data = (array)$this->getData("copy_text", []);
		return new CopyTextButton($data);
	}

	public function getCallbackGame(): array
	{
		return (array)$this->getData("callback_game");
	}

	public function isPay(): bool
	{
		return (bool)$this->getData("pay");
	}

}
