<?php
declare(strict_types=1);

namespace Database\Search;

class Filter implements FilterInterface
{
    /** @var string */
    private $field;
    /** @var mixed */
    private $value;
    /** @var string */
    private $conditionType;
    /** @var string */
    private $concatenation;

    public function __construct(string $field = null, $value = null, string $conditionType = '=', string $concatenation = 'AND')
    {
        $this->field = $field;
        $this->value = $value;
        $this->conditionType = $conditionType;
        $this->concatenation = $concatenation;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function setField(string $field) : FilterInterface
    {
        $this->field = $field;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue(string $value) : FilterInterface
    {
        $this->value = $value;

        return $this;
    }

    public function getConditionType(): string
    {
        return $this->conditionType;
    }

    public function setConditionType(string $conditionType) : FilterInterface
    {
        $this->conditionType = $conditionType;

        return $this;
    }

    public function getConcatenation(): string
    {
        return $this->concatenation;
    }

    public function setConcatenation(string $concatenation) : FilterInterface
    {
        $this->concatenation = $concatenation;

        return $this;
    }
}