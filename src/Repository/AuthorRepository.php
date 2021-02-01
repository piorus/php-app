<?php
declare(strict_types=1);

namespace Repository;

use Database\AdapterInterface;
use Database\Search\SearchCriteriaBuilder;
use Factory\RepositoryFactory;
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

    public function deleteById(int $id)
    {
        /** @var SwipeRepository $swipeRepository */
        $swipeRepository = RepositoryFactory::create(SwipeRepository::class);
        $builder = new SearchCriteriaBuilder();
        $builder->addFilter('author_id', $id);
        $swipes = $swipeRepository->getList($builder->build());
        foreach ($swipes as $swipe) {
            $swipeRepository->deleteById($swipe->getId());
        }

        parent::deleteById($id);
    }
}