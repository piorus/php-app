<?php
declare(strict_types=1);

namespace Repository;

use Database\AdapterInterface;
use Factory\RepositoryFactory;
use Model\Swipe;

class SwipeRepository extends AbstractRepository
{
    public function __construct(
        AdapterInterface $adapter,
        string $tableName = 'swipe',
        string $modelClass = Swipe::class
    ) {
        parent::__construct($adapter, $tableName, $modelClass);
    }

    public function deleteById(int $id)
    {
        /** @var Swipe $swipe */
        $swipe = $this->get($id);
        /** @var SwipeCommentRepository $swipeCommentRepository */
        $swipeCommentRepository = RepositoryFactory::create(SwipeCommentRepository::class);

        foreach($swipe->getSwipeComments() as $swipeComment) {
            $swipeCommentRepository->delete($swipeComment);
        }

        parent::deleteById($id);
    }
}