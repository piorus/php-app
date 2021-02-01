<?php
declare(strict_types=1);

namespace Model;

/**
 * @method string getPassword()
 */
class User extends AbstractEntity
{
    const ENTITY = 'user';

    const COLUMN_ID = 'id';

    protected string $nickname;
    protected string $email;
    protected string $password;
    protected string $role;

    public function isAdmin()
    {
        return $this->role === 'ADMIN';
    }

    public function getNickname() : string
    {
        return $this->nickname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}