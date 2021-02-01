<?php
declare(strict_types=1);

namespace Factory;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigFactory
{
    private static Environment $environment;

    public static function create(string $twigDir = SRC_DIR . 'view', array $options = [])
    {
        if(APPLICATION_MODE === 'prod') {
            $options['cache'] = CACHE_DIR . 'twig';
        }

        if (!isset(self::$environment)) {
            self::$environment = new Environment(
                new FilesystemLoader($twigDir),
                $options
            );
        }

        return self::$environment;
    }
}