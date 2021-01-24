<?php
declare(strict_types=1);

namespace Model;

interface EntityInterface
{
    public function getId() : ?int;
    public function getValues() : array;
}