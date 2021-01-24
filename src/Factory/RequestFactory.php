<?php
declare(strict_types=1);

namespace Factory;

class RequestFactory
{
    public static function create(string $method) : \Request
    {
        return new \Request($method);
    }
}