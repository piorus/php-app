<?php
declare(strict_types=1);

namespace Controller\User;

use Controller\Action\AbstractBackendController;
use Exception\UserAlreadyExistException;
use Exception\UserNicknameIsAlreadyInUseException;
use Factory\RepositoryFactory;
use Repository\UserRepository;

class SignupSubmit extends AbstractBackendController
{
    public function executeBackendAction()
    {
        /** @var UserRepository $userRepository */
        $userRepository = RepositoryFactory::create(UserRepository::class);
        try {
            $userId = $userRepository->create(
                $this->request->get('nickname'),
                $this->request->get('email'),
                $this->request->get('password'),
            );
        } catch (UserAlreadyExistException | UserNicknameIsAlreadyInUseException $e) {
            $this->session->addErrorMessage($e->getMessage());
            $this->redirect('/signup');
        }

        $this->session->login((int)$userId);
        $this->redirect('/');
    }
}