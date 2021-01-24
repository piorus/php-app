<?php
declare(strict_types=1);

namespace Database\Search;

class FilterGroup implements FilterGroupInterface
{
    /** @var array */
    private $filters = [];
    /** @var string */
    private $concatenation;

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