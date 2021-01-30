<?php
declare(strict_types=1);

namespace Controller\Swipe;

use Controller\Action\AbstractUpdateController;
use Model\Swipe;
use Repository\SwipeRepository;

class Update extends AbstractUpdateController
{
    const REQUIRE_LOGGED_IN_ADMIN_USER = true;

    protected $template = 'swipe/update.twig';
    protected $repositoryClass = SwipeRepository::class;
    protected $entity = Swipe::ENTITY;
}