<?php
declare(strict_types=1);

namespace Database;

class PostgresqlAdapter implements AdapterInterface
{
    public function query(string $sql)
    {
        // TODO: Implement query() method.
    }

    public function fetch(array $columns, string $table, array $conditions, int $fetchStyle)
    {
        $gluedColumns = implode(', ', $columns);
        $gluedConditions = '';
        foreach ($conditions as $column => $condition) {
            $gluedConditions .= "$column ";
            $gluedConditions .= $this->convertCondition(array_keys($conditions)[0]);
            $gluedConditions .= " " . array_values($conditions)[0] ?? '';
        }

        $statement = new
    }

    private function convertCondition(string $condition)
    {
        return [
            'eq' => '=',
            'neq' => '!=',
            'null' => 'IS NULL',
            'notnull' => 'IS NOT NULL'
        ][$condition];
    }
}