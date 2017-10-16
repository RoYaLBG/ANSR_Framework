<?php

namespace ANSR\Core\Http\Component;

interface SessionInterface
{
    const KEY_FLASH_ERROR = 'error';
    const KEY_FLASH_SUCCESS = 'success';
    const KEY_FLASH_NOTICE = 'notice';
    const KEY_FLASH_WARN = 'warn';

    public function getAttribute(string $key): string;

    public function setAttribute(string $key, string $value);

    public function addFlashMessage(string $key, string $value);

    public function flushFlashMessages();

    public function getFlashMessages(string $key): array;

    public function destroy();
}

