<?php
declare(strict_types=1);

namespace Controller\Author;

use Controller\Action\AbstractUpdateController;
use Model\Author;
use Repository\AuthorRepository;

class Update extends AbstractUpdateController
{
    const REQUIRE_LOGGED_IN_ADMIN_USER = true;

    protected string $template = 'author/layout/update.twig';
    protected ?string $repositoryClass = AuthorRepository::class;
    protected ?string $entity = Author::ENTITY;
    protected string $pageTitle = 'Update Author';
}