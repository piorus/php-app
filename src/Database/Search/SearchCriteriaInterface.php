<?php
declare(strict_types=1);

namespace Database\Search;

interface SearchCriteriaInterface
{
    /** @return FilterGroupInterface[] */
    public function getFilterGroups(): array;
    public function setFilterGroups(array $filterGroups): void;
}