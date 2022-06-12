<?php

namespace app\core;

class Session
{
    private const FLASH_MESSAGE = 'flash_messages';
    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_MESSAGE] ?? [];
        foreach ($flashMessages as &$flashMessage){
            $flashMessage['remove'] = true;
        }
        $_SESSION[self::FLASH_MESSAGE] = $flashMessages;
    }

    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_MESSAGE][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }

    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_MESSAGE][$key]['value'] ?? false;
    }

    public function __destruct()
    {
        $flashMessages = $_SESSION[self::FLASH_MESSAGE] ?? [];
        foreach ($flashMessages as $key => &$flashMessage){
            if($flashMessage['remove'])
                unset($flashMessages[$key]);
        }
        $_SESSION[self::FLASH_MESSAGE] = $flashMessages;
    }
}