<?php
declare(strict_types=1);

namespace Factory;

class RequestFactory
{
    private static array $instances;

    public static function create(string $method) : \Request
    {
        if(!isset(self::$instances[$method])) {
            self::$instances[$method] = new \Request($method);
        }

        return self::$instances[$method];
    }
}