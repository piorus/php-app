<?php
declare(strict_types=1);

namespace Database\Search;

class SearchCriteria implements SearchCriteriaInterface
{
    /** @var FilterGroup[] */
    private array $filterGroups = [];

    public function addFilterGroup(FilterGroupInterface $filterGroup) : SearchCriteriaInterface
    {
        $this->filterGroups[] = $filterGroup;

        return $this;
    }

    /** @return FilterGroup[] */
    public function getFilterGroups(): array
    {
        return $this->filterGroups;
    }

    /** @param FilterGroup[] $filterGroups */
    public function setFilterGroups(array $filterGroups): void
    {
        $this->filterGroups = $filterGroups;
    }
}