<?php
declare(strict_types=1);

namespace Factory;

use Model\EntityInterface;

class EntityFactory
{
    public static function create(string $entityClass, array $data = []) : EntityInterface
    {
        return new $entityClass($data);
    }
}