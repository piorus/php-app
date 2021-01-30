<?php
declare(strict_types=1);

namespace Exception;

class FileUploadException extends \Exception
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct("File upload failed: $message", $code, $previous);
    }
}