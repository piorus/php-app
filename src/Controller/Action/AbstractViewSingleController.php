<?php
declare(strict_types=1);

namespace Controller\Action;

use Factory\RepositoryFactory;

abstract class AbstractViewSingleController extends AbstractFrontendController
{
    const REQUIRE_LOGGED_IN_USER = true;

    protected ?string $repositoryClass = null;
    protected ?string $entity = null;

    public function getTemplateData() : array
    {
        $repository = RepositoryFactory::create($this->repositoryClass);
        $entity = $repository->get((int) $this->request->get('id'));

        return [
            "{$this->entity}" => $entity,
            'isSingle' => true,
        ];
    }
}