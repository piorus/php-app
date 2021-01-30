<?php
declare(strict_types=1);

namespace Service;

class Serializer
{
    public function serialize($data)
    {
        return json_encode($data);
    }

    public function unserialize(string $json)
    {
        return json_decode($json, true);
    }
}