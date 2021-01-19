<?php
declare(strict_types=1);

class UserRepository extends AbstractRepository
{
    public function __construct(
        \Database\AdapterInterface $adapter,
        string $tableName = 'user',
        string $modelClass = '\\Model\\User'
    ) {
        parent::__construct($adapter, $tableName, $modelClass);
    }
}