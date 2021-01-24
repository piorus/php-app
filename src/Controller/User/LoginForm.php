<?php
declare(strict_types=1);

namespace Controller\User;

use Controller\AbstractFrontendController;
use Controller\Action\GetActionInterface;

class LoginForm extends AbstractFrontendController implements GetActionInterface
{
    protected $template = 'user/login.twig';

    public function execute()
    {
        echo $this->twig->render(
            $this->template,
            ['errors' => $this->session->getErrorMessages()]
        );
    }
}