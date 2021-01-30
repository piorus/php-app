<?php
declare(strict_types=1);

namespace Model;

use Factory\RepositoryFactory;
use Repository\AuthorRepository;

/**
 * @method setName(string $name)
 * @method setAuthorId(int $authorId)
 * @method int getAuthorId()
 * @method setFileUrl(string $fileUrl)
 */
class Swipe extends AbstractEntity
{
    const ENTITY = 'swipe';

    protected $name;
    protected $authorId;
    protected $fileUrl;

    public function getAuthor() : ?Author
    {
        /** @var AuthorRepository $authorRepository */
        $authorRepository = RepositoryFactory::create(AuthorRepository::class);

        return $authorRepository->get($this->authorId);
    }

    public function getName() {
        return $this->name;
    }

    public function getFileUrl() {
        return $this->fileUrl;
    }
}