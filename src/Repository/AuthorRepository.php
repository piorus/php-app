<?php
declare(strict_types=1);

namespace Repository;

use Database\AdapterInterface;
use Model\Author;

class AuthorRepository extends AbstractRepository
{
    public function __construct(
        AdapterInterface $adapter,
        string $tableName = 'author',
        string $modelClass = Author::class
    ) {
        parent::__construct($adapter, $tableName, $modelClass);
    }
}