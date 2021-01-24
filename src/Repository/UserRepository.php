<?php
declare(strict_types=1);

namespace Repository;

use Database\AdapterInterface;
use Database\Search\SearchCriteriaBuilder;
use Exception\UserNicknameIsAlreadyInUseException;
use Factory\ServiceFactory;
use Model\User;

class UserRepository extends AbstractRepository
{
    public function __construct(
        AdapterInterface $adapter,
        string $tableName = 'user',
        string $modelClass = '\\Model\\User'
    )
    {
        parent::__construct($adapter, $tableName, $modelClass);
    }

    public function getUserByEmail(string $email): ?User
    {
        $builder = new SearchCriteriaBuilder();

        $result = $this->adapter->fetch(
            ['*'],
            $this->tableName,
            $builder->addFilter('email', $email)->build()
        );

        return $result ? new User($result) : null;
    }

    public function getUserByNickname(string $nickname) : ?User
    {
        $builder = new SearchCriteriaBuilder();

        $result = $this->adapter->fetch(
            ['*'],
            $this->tableName,
            $builder->addFilter('nickname', $nickname)->build()
        );

        return $result ? new User($result) : null;
    }

    public function create(string $nickname, string $email, string $password)
    {
        $builder = new SearchCriteriaBuilder();

        $user = $this->getUserByEmail($email);

        if ($user) {
            throw new \Exception\UserAlreadyExistException('User with that e-mail address already exists.');
        }

        $user = $this->getUserByNickname($nickname);

        if ($user) {
            throw new UserNicknameIsAlreadyInUseException('This nickname was already taken.');
        }


        /** @var \Service\PasswordManager $passwordManager */
        $passwordManager = (new ServiceFactory())->create('password_manager');

        $this->adapter->insert(
            [
                'nickname' => $nickname,
                'email' => $email,
                'password' => $passwordManager->hash($password),
                'role' => 'USER'
            ],
            $this->tableName
        );

        $data = $this->adapter->fetch(
            [User::ID],
            $this->tableName,
            $builder
                ->addFilter('email', $email)
                ->addFilter('nickname', $nickname)
                ->build()
        );

        return $data[User::ID];
    }
}