<?php
declare(strict_types=1);

namespace Controller\Author;

use Controller\Action\AbstractUpdateController;
use Model\Author;
use Repository\AuthorRepository;

class Update extends AbstractUpdateController
{
    const REQUIRE_LOGGED_IN_ADMIN_USER = true;

    protected $template = 'author/update.twig';
    protected $repositoryClass = AuthorRepository::class;
    protected $entity = Author::ENTITY;
}