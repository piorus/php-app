<?php
declare(strict_types=1);

use Controller\Action\ActionInterface;
use Controller\Action\GetActionInterface;
use Controller\Action\PostActionInterface;
use Exception\RouteDoesNotExistException;
use Factory\ControllerFactory;

class Router
{
    const GET_REQUEST = 'GET';
    const POST_REQUEST = 'POST';

    private $routes = [
        self::GET_REQUEST => [],
        self::POST_REQUEST => []
    ];

    private function getActions()
    {
        return [
            self::GET_REQUEST => GetActionInterface::class,
            self::POST_REQUEST => PostActionInterface::class
        ];
    }

    public function registerRoute(string $path, string $controllerClass)
    {
        $controllerReflection = new ReflectionClass($controllerClass);

        foreach ($this->getActions() as $action => $actionInterface)
        {
            if ($controllerReflection->implementsInterface($actionInterface)) {
                $this->routes[$action][] = [
                    'path' => $path,
                    'controllerClass' => $controllerClass
                ];
            }
        }
    }

    public function getController(): ActionInterface
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes[$requestMethod] as $route) {
            if ($route['path'] === $requestUri) {
                return ControllerFactory::create(
                    $route['controllerClass'],
                    $requestMethod
                );
            }
        }

        throw new RouteDoesNotExistException("Route $requestUri does not exist.");
    }
}