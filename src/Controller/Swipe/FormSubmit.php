<?php
declare(strict_types=1);

namespace Controller\Swipe;

use Controller\AbstractBackendController;
use Controller\Action\PostActionInterface;
use Factory\RepositoryFactory;
use Model\Author;
use Model\Swipe;
use Repository\AuthorRepository;

class FormSubmit extends AbstractBackendController implements PostActionInterface
{
    public function execute()
    {
        $swipe = new Swipe($this->request->getAll());
        /** @var AuthorRepository $authorRepository */
        $authorRepository = RepositoryFactory::create(AuthorRepository::class);
        $authorRepository->save($author);
        $this->redirect('/authors');
    }
}