<?php
declare(strict_types=1);

namespace Database\Search;

interface FilterInterface
{
    public function getField() : string;
    public function setField(string $field) : self;
    public function getValue() : string;
    public function setValue(string $value) : self;
    public function getConditionType() : string;
    public function setConditionType(string $conditionType) : self;
    public function getConcatenation() : string;
    public function setConcatenation(string $concatenation) : self;
}