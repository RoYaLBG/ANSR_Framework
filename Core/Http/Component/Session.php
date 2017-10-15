<?php
namespace ANSR\Core\Http\Component;

use ANSR\Core\Annotation\Type\Component;

/**
 * @Component
 */
class Session implements SessionInterface
{
    private $sessions = [];

    const KEY_FLASH_MESSAGES = '___FLASH___';

    public function __construct(SessionInitializerInterface $sessionInitializer)
    {
        $this->sessions = &$sessionInitializer();
    }

    public function getAttribute(string $key): string
    {
        return isset($this->sessions[$key]) ? $this->sessions[$key] : "";
    }

    public function setAttribute(string $key, string $value)
    {
        $this->sessions[$key] = $value;
    }

    public function addFlashMessage(string $key, string $value)
    {
        $this->sessions[self::KEY_FLASH_MESSAGES][$key][] = $value;
    }

    public function flushFlashMessages()
    {
        $this->sessions[self::KEY_FLASH_MESSAGES] = [];
    }

    public function getFlashMessages(string $key): array
    {
        if (isset($this->sessions[self::KEY_FLASH_MESSAGES][$key])) {
            return $this->sessions[self::KEY_FLASH_MESSAGES][$key];
        }

        return [];
    }

    public function destroy()
    {
        unset($this->sessions);
        session_destroy();
    }
}

