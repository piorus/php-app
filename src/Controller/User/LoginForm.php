<?php
declare(strict_types=1);

namespace Controller\User;

use Controller\Action\AbstractFrontendController;
use Controller\Action\GetActionInterface;

class LoginForm extends AbstractFrontendController implements GetActionInterface
{
    const REQUIRE_LOGGED_IN_USER = false;
    protected $template = 'user/login.twig';
}