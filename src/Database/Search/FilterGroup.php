<?php
declare(strict_types=1);

namespace Database\Search;

class FilterGroup implements FilterGroupInterface
{
    private array $filters = [];
    private string $concatenation;

    public function addFilter(FilterInterface $filter): FilterGroupInterface
    {
        $this->filters[] = $filter;

        return $this;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getConcatenation(): string
    {
        return $this->concatenation;
    }

    public function setConcatenation(string $concatenation) : FilterGroupInterface
    {
        $this->concatenation = $concatenation;

        return $this;
    }
}