<?php
declare(strict_types=1);

namespace Controller\Action;

use Controller\Action\AbstractBackendController;
use Controller\Action\PostActionInterface;
use Factory\RepositoryFactory;
use Repository\AuthorRepository;
use Repository\RepositoryInterface;
use Validator\AdminValidator;

abstract class AbstractDeleteController extends AbstractBackendController
{
    const REQUIRE_LOGGED_IN_ADMIN_USER = true;

    /** @var string|null */
    protected $repositoryClass = null;
    /** @var string|null */
    protected $redirectPath = null;

    public function executeBackendAction()
    {
        /** @var RepositoryInterface $repository */
        $repository = RepositoryFactory::create($this->repositoryClass);
        $repository->deleteById((int) $this->request->get('id'));
        $this->redirect($this->redirectPath);
    }
}