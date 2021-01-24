<?php
declare(strict_types=1);

namespace Database\Search;

interface FilterGroupInterface
{
    public function addFilter(FilterInterface $filter) : self;
    /** @return FilterInterface[] */
    public function getFilters() : array;
    public function getConcatenation() : string;
    public function setConcatenation(string $concatenation) : self;
}