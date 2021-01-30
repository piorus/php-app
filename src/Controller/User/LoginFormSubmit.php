<?php
declare(strict_types=1);

namespace Controller\User;

use Controller\Action\AbstractBackendController;
use Factory\RepositoryFactory;
use Repository\UserRepository;
use Service\Hasher;

class LoginFormSubmit extends AbstractBackendController
{
    protected function executeBackendAction()
    {
        $rawEmail = $_POST['email'] ?? '';
        $rawPassword = $_POST['password'] ?? '';

        /** @var UserRepository $userRepository */
        $userRepository = RepositoryFactory::create(UserRepository::class);
        $user = $userRepository->getUserByEmail($rawEmail);

        /** @var Hasher $hasher */
        $hasher = new Hasher();

        if (!$user) {
            $this->session->addErrorMessage('Incorrect username and/or password.');
            $this->redirect('/login');
        }


        if (!$hasher->verify($rawPassword, $user->getPassword())) {
            $this->session->addErrorMessage('Wrong password.');
            $this->redirect('/login');
        }

        $this->session->login($user->getId());
        $this->redirect('/');
    }
}