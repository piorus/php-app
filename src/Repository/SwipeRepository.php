<?php
declare(strict_types=1);

namespace Repository;

class SwipeRepository extends AbstractRepository
{
    public function __construct(
        \Database\AdapterInterface $adapter,
        string $tableName = 'swipe',
        string $modelClass = '\\Model\\Swipe'
    ) {
        parent::__construct($adapter, $tableName, $modelClass);
    }
}