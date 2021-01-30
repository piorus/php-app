<?php
declare(strict_types=1);

namespace Controller\Swipe;

use Controller\Action\AbstractDeleteController;
use Repository\SwipeRepository;

class Delete extends AbstractDeleteController
{
    const REQUIRE_LOGGED_IN_ADMIN_USER = true;

    /** @var string|null */
    protected $repositoryClass = SwipeRepository::class;
    /** @var string|null */
    protected $redirectPath = '/';
}