<?php

namespace Core;

class Session
{
    public static function put($key, $value): void
    {
        $_SESSION[$key] = $value;
    }
    public static function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public static function destroy(): void
    {
        $_SESSION = [];
        session_destroy();

        setcookie('PHPSESSID', '', time() - 50);
    }
}