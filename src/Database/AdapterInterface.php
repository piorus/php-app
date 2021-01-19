<?php
declare(strict_types=1);

namespace Database;

interface AdapterInterface
{
    public function query(string $sql);
    public function fetch(array $columns, string $table, array $conditions, int $fetchStyle);
}