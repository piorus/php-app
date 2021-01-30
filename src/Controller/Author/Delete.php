<?php
declare(strict_types=1);

namespace Controller\Author;

use Controller\Action\AbstractDeleteController;
use Repository\AuthorRepository;

class Delete extends AbstractDeleteController
{
    const REQUIRE_LOGGED_IN_ADMIN_USER = true;
    /** @var string|null */
    protected $repositoryClass = AuthorRepository::class;
    /** @var string|null */
    protected $redirectPath = '/authors';
}