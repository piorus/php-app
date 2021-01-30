<?php
declare(strict_types=1);

namespace Repository;

use Database\AdapterInterface;
use Database\Search\SearchCriteriaBuilder;
use Exception\UserAlreadyExistException;
use Exception\UserNicknameIsAlreadyInUseException;
use Factory\ServiceFactory;
use Model\User;
use Service\Hasher;

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
            throw new UserAlreadyExistException('User with that e-mail address already exists.');
        }

        $user = $this->getUserByNickname($nickname);
        if ($user) {
            throw new UserNicknameIsAlreadyInUseException('This nickname was already taken.');
        }

        /** @var Hasher $hasher */
        $hasher = new Hasher();

        $this->adapter->insert(
            $this->tableName,
            [
                'nickname' => $nickname,
                'email' => $email,
                'password' => $hasher->hash($password),
                'role' => 'USER'
            ],
        );

        $data = $this->adapter->fetch(
            [User::COLUMN_ID],
            $this->tableName,
            $builder
                ->addFilter('email', $email)
                ->addFilter('nickname', $nickname)
                ->build()
        );

        return $data[User::COLUMN_ID];
    }
}