<?php
declare(strict_types=1);

namespace Repository;

class AuthorRepository extends AbstractRepository
{
    public function __construct(
        \Database\AdapterInterface $adapter,
        string $tableName = 'author',
        string $modelClass = '\\Model\\Author'
    ) {
        parent::__construct($adapter, $tableName, $modelClass);
    }
}