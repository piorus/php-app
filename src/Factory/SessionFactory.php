<?php
declare(strict_types=1);

namespace Factory;

class SessionFactory
{
    private static \Session $session;

    public static function create()
    {
        if(!isset(self::$session)) {
            self::$session = new \Session();
        }

        return self::$session;
    }
}