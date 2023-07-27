<?php

namespace Core\Database;

use PDO;
use PDOStatement;
use PDOException;

class QueryBuilder
{
    protected PDO $connection;
    protected PDOStatement $statement;
    public function __construct($connection)
    {
        $this->connection = $connection;
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
    protected function parseSqlParams($params = []): array
    {
        $columns = implode(',', array_keys($params));
        $wildCards = ':' . implode(', :', array_keys($params));

        return ['columns' => $columns, 'wildCards' => $wildCards];
    }
    public function insert($table, $params = []): void
    {
        $sqlParams = $this->parseSqlParams($params);
        $sql = "INSERT INTO {$table} ({$sqlParams['columns']}) VALUES({$sqlParams['wildCards']})";

        $this->query($sql, $params);
    }
    public function selectAll($table, $params = []): bool|array
    {
        $sql = "SELECT * FROM {$table}";

        return $this->query($sql, $params)->fetchAll(PDO::FETCH_CLASS);
    }
    public function selectById($table, $id, $params = [])
    {
        $sql = "SELECT * FROM {$table} WHERE id = {$id}";

        return $this->query($sql, $params)->fetch(PDO::FETCH_OBJ);
    }
    public function selectWhere($table, $whereOperator, $params = []): bool|array
    {
        $sqlParams = $this->parseSqlParams($params);
        $sql = "SELECT * FROM {$table} WHERE {$sqlParams['columns']} {$whereOperator} {$sqlParams['wildCards']}";

        return $this->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function selectColumnWhere(string $table, array $column = [], string $whereOperator = '=', array $params = []): bool|array
    {
        $sqlParams = $this->parseSqlParams($params);
        $sql = "SELECT " . implode(', ', $column) . " FROM {$table} WHERE {$sqlParams['columns']} {$whereOperator} {$sqlParams['wildCards']}";

        return $this->query($sql, $params)->fetchAll(PDO::FETCH_DEFAULT);
    }
    public function updateColumn(string $table, string $column, mixed $value, string $whereOperator, array $params = []): bool|PDOStatement
    {
        $sqlParams = $this->parseSqlParams($params);
        $sql = "UPDATE {$table} SET {$column} = {$value} WHERE {$sqlParams['columns']} {$whereOperator} {$sqlParams['wildCards']}";

        return $this->query($sql, $params);
    }
    public function deleteFromTable(string $table, array $params = []): bool|PDOStatement
    {
        $sqlParams = $this->parseSqlParams($params);
        $sql = "DELETE FROM {$table} WHERE {$sqlParams['columns']} = {$sqlParams['wildCards']}";

        return $this->query($sql, $params);
    }

}