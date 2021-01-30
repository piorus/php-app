<?php
declare(strict_types=1);

namespace Controller\User;

use Controller\Action\AbstractFrontendController;
use Controller\Action\GetActionInterface;

class Signup extends AbstractFrontendController implements GetActionInterface
{
    protected $template = 'user/signup.twig';
}