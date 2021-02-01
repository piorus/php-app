<?php
declare(strict_types=1);

namespace Model;

use Factory\RepositoryFactory;
use Repository\UserRepository;

class SwipeComment extends AbstractEntity
{
    const ENTITY = 'swipe_comment';
    protected int $userId;
    protected int $swipeId;
    protected string $comment;

    public function getUser() : User
    {
        /** @var UserRepository $userRepository */
        $userRepository = RepositoryFactory::create(UserRepository::class);

        return $userRepository->get($this->userId);
    }

    public function getUserId() : int
    {
        return $this->userId;
    }
}