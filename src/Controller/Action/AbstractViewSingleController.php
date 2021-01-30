<?php
declare(strict_types=1);

namespace Controller\Action;

use Database\Search\SearchCriteria;
use Factory\RepositoryFactory;
use Repository\RepositoryInterface;

abstract class AbstractViewSingleController extends AbstractFrontendController
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
        $entity = $repository->get((int) $this->request->get('id'));

        return [
            "{$this->entity}" => $entity,
            'isSingle' => true
        ];
    }
}