<?php
declare(strict_types=1);

namespace Controller\User;

use Controller\AbstractFrontendController;
use Controller\Action\GetActionInterface;

class Logout extends AbstractFrontendController implements GetActionInterface
{
    public function execute()
    {
        $this->session->logout();
        $this->session->addErrorMessage('Logged out.');
        $this->redirect('/login');
    }
}