<?php
declare(strict_types=1);

namespace Controller\Swipe;

use Controller\AbstractFrontendController;
use Controller\Action\GetActionInterface;
use Database\Search\SearchCriteria;
use Database\Search\SearchCriteriaBuilder;
use Factory\RepositoryFactory;
use Repository\AuthorRepository;

class Add extends AbstractFrontendController implements GetActionInterface
{
    protected $template = 'swipe/add.twig';

    public function execute()
    {
        /** @var AuthorRepository $authorRepository */
        $authorRepository = RepositoryFactory::create(AuthorRepository::class);
        $authors = $authorRepository->getList(new SearchCriteria());
        $this->render(['authors' => $authors]);
    }
}