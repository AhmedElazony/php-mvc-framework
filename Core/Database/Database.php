<?php

namespace Core\Database;

use PDO;
use PDOException;
use PDOStatement;

class Database
{
    protected PDO $connection;
    protected PDOStatement $statement;
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }
    public static function connect($config): PDO|bool
    {
        return Connection::make($config);
    }
    protected function query($query, $params = [])
    {
        try {
            $this->statement = $this->connection->prepare($query);
            $this->statement->execute($params);
        }  catch (PDOException $exception) {
            die($exception->getMessage());
        }
        return $this->statement;
    }
}