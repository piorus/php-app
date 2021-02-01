<?php
declare(strict_types=1);

namespace Controller\Swipe;

use Controller\Action\AbstractUpdateController;
use Database\Search\SearchCriteria;
use Factory\RepositoryFactory;
use Model\Swipe;
use Repository\AuthorRepository;
use Repository\SwipeRepository;

class Update extends AbstractUpdateController
{
    const REQUIRE_LOGGED_IN_ADMIN_USER = true;

    protected string $template = 'swipe/layout/update.twig';
    protected ?string $repositoryClass = SwipeRepository::class;
    protected ?string $entity = Swipe::ENTITY;

    public function getTemplateData(): array
    {
        $templateData = parent::getTemplateData();
        /** @var AuthorRepository $authorRepository */
        $authorRepository = RepositoryFactory::create(AuthorRepository::class);
        $templateData['authors'] = $authorRepository->getList(new SearchCriteria());

        return $templateData;
    }
}