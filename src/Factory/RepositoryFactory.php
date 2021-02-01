<?php
declare(strict_types=1);

namespace Factory;

use Database\AdapterInterface;
use Database\DatabaseAdapter;
use Repository\RepositoryInterface;

class RepositoryFactory
{
    private static array $instances;
    private static AdapterInterface $databaseAdapter;

    public static function create(string $repositoryClass) : RepositoryInterface
    {
        if(!isset(self::$databaseAdapter)) {
            self::$databaseAdapter = new DatabaseAdapter();
        }

        if(!isset(self::$instances[$repositoryClass])) {
            self::$instances[$repositoryClass] = new $repositoryClass(self::$databaseAdapter);
        }

        return self::$instances[$repositoryClass];
    }
}