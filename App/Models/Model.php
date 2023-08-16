<?php

namespace App\Models;

use Core\Database\QueryBuilder;

class Model
{
    protected QueryBuilder $db;
    public function __construct(QueryBuilder $db)
    {
        $this->db = $db;
    }
}