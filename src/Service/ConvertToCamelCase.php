<?php
declare(strict_types=1);

namespace Service;

class ConvertToCamelCase
{
    public function execute(string $value)
    {
        return lcfirst(str_replace('_', '', ucwords($value, '_')));
    }
}