<?php
declare(strict_types=1);

namespace Controller\Action;

use Database\Search\SearchCriteria;
use Factory\RepositoryFactory;

abstract class AbstractViewListController extends AbstractFrontendController
{
    const REQUIRE_LOGGED_IN_USER = true;

    protected ?string $repositoryClass = null;
    protected ?string $entity = null;

    public function getTemplateData() : array
    {
        $repository = RepositoryFactory::create($this->repositoryClass);
        $entities = $repository->getList(new SearchCriteria());

        return ["{$this->entity}s" => $entities];
    }
}