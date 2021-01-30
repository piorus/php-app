<?php
declare(strict_types=1);

namespace Service;

class Hasher
{
    public function hash(string $password) : string
    {
        return password_hash($password, PASSWORD_ARGON2ID);
    }

    public function verify(string $password, string $hash) : bool
    {
        return password_verify($password, $hash);
    }

    public function randomHash() : string
    {
        return hash('sha256', random_bytes(256));
    }
}