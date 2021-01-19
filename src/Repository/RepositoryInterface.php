<?php
declare(strict_types=1);

interface RepositoryInterface
{
    public function get(int $id);
    public function getList(\Database\SearchCriteriaInterface $searchCriteria);
    public function save(\Model\EntityInterface $entity);
    public function delete(\Model\EntityInterface $entity);
    public function deleteById(int $id);
}