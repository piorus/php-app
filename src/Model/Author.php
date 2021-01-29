<?php
declare(strict_types=1);

namespace Model;

class Author extends AbstractEntity
{
    protected $firstName;
    protected $lastName;
    protected $bio;

    public function getId() : int
    {
        return $this->id;
    }

    public function getFirstName() : string
    {
        return $this->firstName;
    }

    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName() :string
    {
        return $this->lastName;
    }

    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getBio() : string
    {
        return $this->bio;
    }

    public function setBio($bio): void
    {
        $this->bio = $bio;
    }
}