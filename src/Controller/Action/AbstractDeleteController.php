<?php
declare(strict_types=1);

namespace Controller\Action;

use Factory\RepositoryFactory;

abstract class AbstractDeleteController extends AbstractBackendController
{
    const REQUIRE_LOGGED_IN_ADMIN_USER = true;

    protected ?string $repositoryClass = null;
    protected ?string $redirectPath = null;

    public function executeBackendAction()
    {
        $repository = RepositoryFactory::create($this->repositoryClass);
        $repository->deleteById((int) $this->request->get('id'));
        $this->redirect($this->redirectPath);
    }
}