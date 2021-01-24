<?php
declare(strict_types=1);

namespace Controller;

use Controller\Action\GetActionInterface;
use Factory\RepositoryFactory;
use Repository\SwipeRepository;

class Homepage extends AbstractFrontendController implements GetActionInterface
{
    protected $template = 'homepage.twig';

    public function execute()
    {
        if(!$this->session->isLoggedIn()) {
            $this->redirect('/login');
        }

        $this->render([]);
    }
}