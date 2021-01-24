<?php
declare(strict_types=1);

namespace Database\Search;

interface SearchCriteriaInterface
{
    public function addFilterGroup(FilterGroupInterface $filterGroup) : self;
    /** @return FilterGroupInterface[] */
    public function getFilterGroups(): array;
    public function setFilterGroups(array $filterGroups): void;
}