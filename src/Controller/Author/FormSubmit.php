<?php
declare(strict_types=1);

namespace Controller\Author;

use Controller\Action\AbstractBackendController;
use Factory\RepositoryFactory;
use Model\Author;
use Repository\AuthorRepository;

class FormSubmit extends AbstractBackendController
{
    const REQUIRE_LOGGED_IN_ADMIN_USER = true;

    public function executeBackendAction()
    {
        $author = new Author($this->request->getAll());
        /** @var AuthorRepository $authorRepository */
        $authorRepository = RepositoryFactory::create(AuthorRepository::class);
        $authorRepository->save($author);
        $this->redirect('/authors');
    }
}