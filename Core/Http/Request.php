<?php

namespace Core\Http;

class Request
{
    public static function uri(): string
    {
        return trim(  // to delete the '/' from the end of the path.
            parse_url($_SERVER['REQUEST_URI'])['path'],
            '/');
    }
    public static function method(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }
}