<?php

namespace Core\Http;

class Response
{
    public const NOT_FOUND = 404;
    public const FORBIDDEN = 403;

    public static function setStatusCode($code): void
    {
        http_response_code($code);
    }
}