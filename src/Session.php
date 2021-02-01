<?php
declare(strict_types=1);

use Factory\RepositoryFactory;
use Model\User;
use Repository\UserRepository;

class Session
{
    const KEY_ERROR_MESSAGES = 'error_messages';
    const KEY_USER_ID = 'user_id';

    public function __construct()
    {
        session_start();
    }

    public function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    public function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function has(string $key) : bool
    {
        return isset($_SESSION[$key]);
    }

    public function unset(string $key)
    {
        if(isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public function getUser() : ?User
    {
        if(!$this->isLoggedIn()) {
            return null;
        }

        /** @var UserRepository $userRepository */
        $userRepository = RepositoryFactory::create(UserRepository::class);

        return $userRepository->get($this->get(self::KEY_USER_ID));
    }

    public function isLoggedIn(): bool
    {
        return $this->has(self::KEY_USER_ID);
    }

    public function login(int $userId)
    {
        $this->set(self::KEY_USER_ID, $userId);
    }

    public function logout()
    {
        $this->unset(self::KEY_USER_ID);
    }

    public function addErrorMessage(string $message)
    {
        $errorMessages = $this->get(self::KEY_ERROR_MESSAGES) ?? [];
        $errorMessages[] = $message;

        $this->set(self::KEY_ERROR_MESSAGES, $errorMessages);
    }

    public function getErrorMessages() : array
    {
        $errorMessages = $this->get(self::KEY_ERROR_MESSAGES) ?? [];
        $this->set(self::KEY_ERROR_MESSAGES, []);

        return $errorMessages;
    }
}