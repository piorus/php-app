<?php
declare(strict_types=1);

namespace Database;

use Database\Search\SearchCriteriaInterface;

interface AdapterInterface
{
    public function fetch(array $columns, string $table, SearchCriteriaInterface $searchCriteria, int $fetchStyle = \PDO::FETCH_ASSOC);
    public function fetchAll(array $columns, string $table, SearchCriteriaInterface $searchCriteria, int $fetchStyle = \PDO::FETCH_ASSOC);
    public function insert(string $table, array $columns);
    public function update(string $table, SearchCriteriaInterface $searchCriteria, array $columns);
    public function delete(string $table, SearchCriteriaInterface $searchCriteria);
}