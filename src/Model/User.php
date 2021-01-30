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
}