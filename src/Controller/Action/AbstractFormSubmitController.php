<?php
declare(strict_types=1);

namespace Controller\Action;

use Factory\EntityFactory;
use Factory\RepositoryFactory;
use Model\EntityInterface;

class AbstractFormSubmitController extends AbstractBackendController
{
    const REQUIRE_LOGGED_IN_ADMIN_USER = true;

    protected ?string $entityClass = null;
    protected ?string $repositoryClass = null;
    protected string $redirectPath = '';

    protected function beforeSave(EntityInterface $entity)
    {
    }

    protected function afterSave(EntityInterface $entity)
    {
        $this->redirect($this->redirectPath);
    }

    protected function executeBackendAction()
    {
        $entity = EntityFactory::create($this->entityClass, $this->request->getAll());
        $repository = RepositoryFactory::create($this->repositoryClass);

        $this->beforeSave($entity);
        $repository->save($entity);
        $this->afterSave($entity);
    }
}