<?php
declare(strict_types=1);

namespace Model;

use Database\Search\SearchCriteriaBuilder;
use Factory\RepositoryFactory;
use Repository\AuthorRepository;
use Repository\SwipeCommentRepository;

/**
 * @method setName(string $name)
 * @method setAuthorId(int $authorId)
 * @method int getAuthorId()
 * @method setFileUrl(string $fileUrl)
 */
class Swipe extends AbstractEntity
{
    const ENTITY = 'swipe';

    protected string $name;
    protected int $authorId;
    protected string $fileUrl;

    public function getAuthor() : ?Author
    {
        /** @var AuthorRepository $authorRepository */
        $authorRepository = RepositoryFactory::create(AuthorRepository::class);

        return $authorRepository->get($this->authorId);
    }

    public function getName() : string {
        return $this->name;
    }

    public function getFileUrl() : string {
        return $this->fileUrl;
    }

    /**
     * @return SwipeComment[]
     */
    public function getSwipeComments() : array
    {
        /** @var SwipeCommentRepository $swipeCommentRepository */
        $swipeCommentRepository = RepositoryFactory::create(SwipeCommentRepository::class);
        $builder = new SearchCriteriaBuilder();
        $builder->addFilter('swipe_id', $this->id);

        return $swipeCommentRepository->getList($builder->build());
    }
}