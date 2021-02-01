<?php
declare(strict_types=1);

namespace Controller\Swipe;

use Controller\Action\AbstractFrontendController;
use Controller\Action\GetActionInterface;
use Database\Search\SearchCriteria;
use Factory\RepositoryFactory;
use Repository\AuthorRepository;

class Create extends AbstractFrontendController implements GetActionInterface
{
    public const REQUIRE_LOGGED_IN_ADMIN_USER = true;

    protected string $template = 'swipe/layout/create.twig';
    protected string $pageTitle = 'Add New Swipe';

    public function getTemplateData(): array
    {
        $templateData = parent::getTemplateData();

        /** @var AuthorRepository $authorRepository */
        $authorRepository = RepositoryFactory::create(AuthorRepository::class);
        $templateData['authors'] = $authorRepository->getList(new SearchCriteria());

        return $templateData;
    }
}