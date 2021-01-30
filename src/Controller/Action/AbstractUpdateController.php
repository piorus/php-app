<?php
declare(strict_types=1);

namespace Controller\Action;

use Controller\Action\AbstractFrontendController;
use Controller\Action\GetActionInterface;
use Factory\RepositoryFactory;
use Repository\AuthorRepository;

abstract class AbstractUpdateController extends AbstractFrontendController
{
    const REQUIRE_LOGGED_IN_ADMIN_USER = true;

    /** @var string|null */
    protected $repositoryClass = null;
    /** @var string|null */
    protected $entity = null;

    public function getTemplateData() : array
    {
        /** @var \Repository\RepositoryInterface $repository */
        $repository = RepositoryFactory::create($this->repositoryClass);
        $entity = $repository->get((int)$this->request->get('id'));

        return [$this->entity => $entity];
    }
}