<?php
declare(strict_types=1);

namespace Controller\Author;

use Controller\Action\AbstractFrontendController;

class Create extends AbstractFrontendController
{
    const REQUIRE_LOGGED_IN_ADMIN_USER = true;
    protected $template = 'author/create.twig';
}