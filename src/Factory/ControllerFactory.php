<?php
declare(strict_types=1);

namespace Factory;

use Controller\Action\ActionInterface;

class ControllerFactory
{
    public static function create(string $controllerClass, string $requestMethod) : ActionInterface
    {
        return new $controllerClass(
            new \Session(),
            RequestFactory::create($requestMethod)
        );
    }
}