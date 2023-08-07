<?php

namespace Core\Database;

use PDO;
use PDOException;

class Connection
{
    public static function make($config): bool|PDO
    {
        try {
            $dsn = "mysql:" . http_build_query($config, '', ';');

            $pdo = new PDO($dsn);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            return $pdo;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return false;
        }
    }
}