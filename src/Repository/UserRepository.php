<?php
declare(strict_types=1);

namespace Repository;

use Database\AdapterInterface;
use Database\Search\SearchCriteriaBuilder;
use Database\Search\SearchCriteriaInterface;
use Exception\UserAlreadyExistException;
use Exception\UserNicknameIsAlreadyInUseException;
use Factory\EntityFactory;
use Model\User;
use Service\Hasher;

class UserRepository extends AbstractRepository
{
    public function __construct(
        AdapterInterface $adapter,
        string $tableName = 'user',
        string $modelClass = User::class
    )
    {
        parent::__construct($adapter, $tableName, $modelClass);
    }

    private function getUserBy(SearchCriteriaInterface $searchCriteria) : ?User
    {
        $data = $this->adapter->fetch(
            ['*'],
            $this->tableName,
            $searchCriteria
        );

        if(!$data) {
            return null;
        }

        /** @var User $user */
        $user = EntityFactory::create(User::class, $data);

        return $user;
    }

    public function getUserByEmail(string $email): ?User
    {
        $builder = new SearchCriteriaBuilder();
        $builder->addFilter('email', $email);

        return $this->getUserBy($builder->build());
    }

    public function getUserByNickname(string $nickname) : ?User
    {
        $builder = new SearchCriteriaBuilder();
        $builder->addFilter('nickname', $nickname);

        return $this->getUserBy($builder->build());
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