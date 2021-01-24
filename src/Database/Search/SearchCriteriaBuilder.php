<?php
declare(strict_types=1);

namespace Database\Search;

class SearchCriteriaBuilder implements \Database\Search\SearchCriteriaInterface
{
    private $searchCriteria;
    /** @var FilterGroup|null */
    private $currentFilterGroup = null;

    public function __construct()
    {
        $this->searchCriteria = new SearchCriteria();
        $this->currentFilterGroup = new FilterGroup();
    }

    public function setFilterGroupConcatenation(string $concatenation) : self
    {
        $this->currentFilterGroup->setConcatenation($concatenation);

        return $this;
    }

    public function addFilterGroup(string $concatenation = 'AND') : self
    {
        if ($this->currentFilterGroup) {
            $this->searchCriteria->addFilterGroup($this->currentFilterGroup);
        }

        $this->currentFilterGroup = new FilterGroup();
        $this->currentFilterGroup->setConcatenation($concatenation);

        return $this;
    }

    public function addFilter(string $field, string $value, string $conditionType = '=') : self
    {
        $this->currentFilterGroup->addFilter(
            new Filter($field, $value, $conditionType)
        );

        return $this;
    }

    public function build() : SearchCriteriaInterface
    {
        $this->searchCriteria->addFilterGroup($this->currentFilterGroup);
        $searchCriteria = clone $this->searchCriteria;
        $this->searchCriteria = new SearchCriteria();

        return $searchCriteria;
    }
}