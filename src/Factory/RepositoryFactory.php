<?php
declare(strict_types=1);

namespace Factory;

use Database\DatabaseAdapter;

class RepositoryFactory
{
    public static function create(string $repositoryClass)
    {
        return new $repositoryClass(new DatabaseAdapter());
    }
}