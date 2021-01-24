<?php
declare(strict_types=1);

namespace Service;

class ConvertToSnakeCase
{
    /**
     * @param string $value
     * @return string
     *
     * @see https://stackoverflow.com/a/1993772/14305541
     */
    public function execute(string $value)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $value, $matches);
        $result = $matches[0];

        foreach ($result as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }

        return implode('_', $result);
    }
}