<?php
declare(strict_types=1);

namespace Repository;

use Database\Search\SearchCriteriaInterface;
use Model\EntityInterface;

interface RepositoryInterface
{
    public function get(int $id);
    public function getList(SearchCriteriaInterface $searchCriteria);
    public function save(EntityInterface $entity);
    public function delete(EntityInterface $entity);
    public function deleteById(int $id);
}