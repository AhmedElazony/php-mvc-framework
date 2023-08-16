<?php

namespace Core;

class Validator
{
    public static function string($string, $min = 7, $max = PHP_INT_MAX): bool
    {
        $value = trim($string);

        return strlen($value) > $min && strlen($value) < $max;
    }

    public static function email($email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}