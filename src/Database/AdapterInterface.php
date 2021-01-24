<?php
declare(strict_types=1);

namespace Database;

use Database\Search\SearchCriteriaInterface;

interface AdapterInterface
{
    public function fetch(array $columns, string $table, SearchCriteriaInterface $searchCriteria, int $fetchStyle = \PDO::FETCH_ASSOC);
    public function fetchAll(array $columns, string $table, SearchCriteriaInterface $searchCriteria, int $fetchStyle = \PDO::FETCH_ASSOC);
    public function insert(array $columns, string $table);
}