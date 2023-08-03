<?php

namespace Core;

class ErrorBag
{
    protected static array $errors = [];
    public static function errors(): array
    {
        return self::$errors;
    }
    public static function setError($errorKey, $errorBody): void
    {
        self::$errors[$errorKey] = $errorBody;
    }
}