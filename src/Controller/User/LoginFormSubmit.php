<?php
declare(strict_types=1);

namespace Controller\User;

use Controller\AbstractBackendController;
use Controller\Action\PostActionInterface;
use Factory\RepositoryFactory;
use Factory\ServiceFactory;
use Repository\UserRepository;

class LoginFormSubmit extends AbstractBackendController implements PostActionInterface
{
    public function execute()
    {
        $rawEmail = $_POST['email'] ?? '';
        $rawPassword = $_POST['password'] ?? '';

        /** @var UserRepository $userRepository */
        $userRepository = RepositoryFactory::create(UserRepository::class);
        $user = $userRepository->getUserByEmail($rawEmail);

        /** @var \Service\PasswordManager $passwordManager */
        $passwordManager = (new ServiceFactory())->create('password_manager');

        if (!$user) {
            $this->session->addErrorMessage('Incorrect username and/or password.');
            $this->redirect('/login');
        }


        if (!$passwordManager->verify($rawPassword, $user->getPassword())) {
            $this->session->addErrorMessage('Wrong password.');
            $this->redirect('/login');
        }

        $this->session->login($user->getId());
        $this->redirect('/');
    }
}