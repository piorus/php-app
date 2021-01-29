<?php
declare(strict_types=1);

namespace Controller\Author;

use Controller\AbstractFrontendController;
use Controller\Action\GetActionInterface;
use Factory\RepositoryFactory;
use Repository\AuthorRepository;

class Update extends AbstractFrontendController implements GetActionInterface
{
    protected $template = 'author/update.twig';

    public function execute()
    {
        /** @var AuthorRepository $authorRepository */
        $authorRepository = RepositoryFactory::create(AuthorRepository::class);
        $author = $authorRepository->get((int)$this->request->get('id'));

        $this->render(['author' => $author]);
    }
}