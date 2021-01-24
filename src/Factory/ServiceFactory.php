<?php
declare(strict_types=1);

namespace Factory;

class ServiceFactory
{
    private $services = [
        'password_manager' => \Service\PasswordManager::class
    ];

    public function create(string $serviceName)
    {
        return isset($this->services[$serviceName]) ? new $this->services[$serviceName]() : null;
    }
}