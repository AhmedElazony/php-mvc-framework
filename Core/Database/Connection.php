<?php

namespace Core\Database;

use PDO;
use PDOException;

class Connection
{
    public static function make($config, $user = 'root', $password = ''): bool|PDO
    {
        try {
            $dsn = 'mysql:' . http_build_query($config, '', ';');

            return new PDO($dsn, $user, $password, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return false;
        }
    }
}