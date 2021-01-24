<?php
declare(strict_types=1);

namespace Model;

class User extends AbstractEntity
{
    const ID = 'id';
    const NICKNAME = 'nickname';
    const EMAIL = 'email';
    const PASSWORD = 'password';
    const ROLE = 'role';

    /** @var int */
    protected $id;
    /** @var string */
    protected $nickname;
    /** @var string */
    protected $email;
    /** @var string */
    protected $password;
    /** @var string */
    protected $role;

    public function isAdmin()
    {
        return $this->role === 'ADMIN';
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     */
    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }
}