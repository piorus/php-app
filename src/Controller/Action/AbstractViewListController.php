<?php
declare(strict_types=1);

namespace Controller\Action;

use Database\Search\SearchCriteria;
use Factory\RepositoryFactory;
use Repository\RepositoryInterface;

abstract class AbstractViewListController extends AbstractFrontendController
{
    const REQUIRE_LOGGED_IN_USER = true;

    /** @var string|null */
    protected $repositoryClass = null;
    /** @var string|null */
    protected $entity = null;

    public function getTemplateData() : array
    {
        /** @var RepositoryInterface $repository */
        $repository = RepositoryFactory::create($this->repositoryClass);
        $entities = $repository->getList(new SearchCriteria());

        return ["{$this->entity}s" => $entities];
    }
}