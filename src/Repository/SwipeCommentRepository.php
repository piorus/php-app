<?php
declare(strict_types=1);

namespace Repository;

class SwipeCommentRepository extends AbstractRepository
{
    public function __construct(
        \Database\AdapterInterface $adapter,
        string $tableName = 'swipe_comment',
        string $modelClass = '\\Model\\SwipeComment'
    ) {
        parent::__construct($adapter, $tableName, $modelClass);
    }
}