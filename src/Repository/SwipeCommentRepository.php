<?php
declare(strict_types=1);

namespace Repository;

use Database\AdapterInterface;
use Model\SwipeComment;

class SwipeCommentRepository extends AbstractRepository
{
    public function __construct(
        AdapterInterface $adapter,
        string $tableName = 'swipe_comment',
        string $modelClass = SwipeComment::class
    ) {
        parent::__construct($adapter, $tableName, $modelClass);
    }
}