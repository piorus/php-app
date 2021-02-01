<?php
declare(strict_types=1);

namespace Model;

class Author extends AbstractEntity
{
    const ENTITY = 'author';

    protected string $firstName;
    protected string $lastName;
    protected string $bio;

    public function getFirstName() : string
    {
        return $this->firstName;
    }

    public function getLastName() :string
    {
        return $this->lastName;
    }

    public function getBio() : string
    {
        return $this->bio;
    }
}