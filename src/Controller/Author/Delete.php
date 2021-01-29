<?php
declare(strict_types=1);

namespace Controller\Author;

use Controller\AbstractBackendController;
use Controller\Action\PostActionInterface;
use Factory\RepositoryFactory;
use Repository\AuthorRepository;
use Validator\AdminValidator;

class Delete extends AbstractBackendController implements PostActionInterface
{
    public function execute()
    {
        $adminValidator = new AdminValidator();
        if(!$adminValidator->validate($this->session)) {
            $this->session->addErrorMessage('Sneaky, but you are not an admin :(');
            $this->redirect('/');
        }

        /** @var AuthorRepository $authorRepository */
        $authorRepository = RepositoryFactory::create(AuthorRepository::class);
        $authorRepository->deleteById((int) $this->request->get('id'));
        $this->redirect('/authors');
    }
}