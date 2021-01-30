<?php
declare(strict_types=1);

namespace Service;

class ConvertFilePathToUrl
{
    public function execute(string $filePath)
    {
        return str_replace(PUB_DIR, '', $filePath);
    }
}