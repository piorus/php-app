<?php
declare(strict_types=1);

namespace Model;

interface EntityInterface
{
    public function getValues() : array;
}