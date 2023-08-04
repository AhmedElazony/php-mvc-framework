<?php

namespace Core\Database;

use PDO;
use PDOStatement;
use PDOException;

class QueryBuilder extends Database
{
    protected function parseSqlParams($params = []): array
    {
        $columns = implode(',', array_keys($params));
        $wildCards = ':' . implode(', :', array_keys($params));

        return ['columns' => $columns, 'wildCards' => $wildCards];
    }
    public function insert($table, $params = []): void
    {
        $sqlParams = $this->parseSqlParams($params);
        $sql = "INSERT INTO {$table}({$sqlParams['columns']}) VALUES({$sqlParams['wildCards']})";

        $this->query($sql, $params);
    }
    public function selectAll($table, $filters,$params = []): bool|array
    {
        $sql = "SELECT * FROM {$table} WHERE {$filters}";

        return $this->query($sql, $params)->fetchAll();
    }
    public function selectById($table, $id, $params = [])
    {
        $sql = "SELECT * FROM {$table} WHERE id = {$id}";

        return $this->query($sql, $params)->fetch();
    }
    public function selectWhere($table, $whereOperator = '=', $params = []): bool|array
    {
        $sqlParams = $this->parseSqlParams($params);
        $sql = "SELECT * FROM {$table} WHERE {$sqlParams['columns']} {$whereOperator} {$sqlParams['wildCards']}";

        return $this->query($sql, $params)->fetch();
    }
    public function selectColumnWhere(string $table, array $column = [], string $whereOperator = '=', array $params = []): bool|array
    {
        $sqlParams = $this->parseSqlParams($params);
        $sql = "SELECT " . implode(', ', $column) . " FROM {$table} WHERE {$sqlParams['columns']} {$whereOperator} {$sqlParams['wildCards']}";

        return $this->query($sql, $params)->fetch();
    }
    public function update(string $table, string $columnValue, array $params = []): bool|PDOStatement
    {
        $sqlParams = $this->parseSqlParams($params);

        $sql = "UPDATE {$table} SET " . $columnValue . " WHERE {$sqlParams['columns']} = {$sqlParams['wildCards']}";

        return $this->query($sql, $params);
    }
    public function delete(string $table, array $params = []): bool|PDOStatement
    {
        $sqlParams = $this->parseSqlParams($params);
        $sql = "DELETE FROM {$table} WHERE {$sqlParams['columns']} = {$sqlParams['wildCards']}";

        return $this->query($sql, $params);
    }

}