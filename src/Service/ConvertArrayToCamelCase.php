<?php
declare(strict_types=1);

namespace Service;

class ConvertArrayToCamelCase
{
    public function execute(array $rows) : array
    {
        $convertToCamelCase = new ConvertToCamelCase();

        foreach($rows as &$row) {
            foreach($row as $column => $value) {
                $camelCasedColumn = $convertToCamelCase->execute($column);
                if($camelCasedColumn !== $column) {
                    unset($row[$column]);
                    $row[$camelCasedColumn] = $value;
                }
            }
        }

        return $rows;
    }
}