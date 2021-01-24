<?php
declare(strict_types=1);

namespace Controller\Author;

use Controller\AbstractBackendController;
use Controller\Action\PostActionInterface;
use Factory\RepositoryFactory;
use Model\Author;
use Repository\AuthorRepository;

class FormSubmit extends AbstractBackendController implements PostActionInterface
{
    public function execute()
    {
        $author = new Author($this->request->getAll());
        /** @var AuthorRepository $authorRepository */
        $authorRepository = RepositoryFactory::create(AuthorRepository::class);
        $authorRepository->save($author);
        $this->redirect('/authors');
    }
}