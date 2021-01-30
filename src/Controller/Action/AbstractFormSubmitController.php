<?php
declare(strict_types=1);

namespace Controller\Action;

use Factory\RepositoryFactory;
use Model\EntityInterface;

class AbstractFormSubmitController extends AbstractBackendController
{
    const REQUIRE_LOGGED_IN_ADMIN_USER = true;

    /** @var string|null */
    protected $entityClass = null;
    /** @var string|null */
    protected $repositoryClass = null;
    /** @var string */
    protected $redirectPath = '';

    protected function beforeSave(EntityInterface $entity)
    {
    }

    protected function afterSave(EntityInterface $entity)
    {
        $this->redirect($this->redirectPath);
    }

    protected function executeBackendAction()
    {
        $entity = new $this->entityClass($this->request->getAll());
        /** @var \Repository\RepositoryInterface $repository */
        $repository = RepositoryFactory::create($this->repositoryClass);
        $this->beforeSave($entity);
        $repository->save($entity);
        $this->afterSave($entity);
    }
}