<?php
declare(strict_types=1);

namespace Validation;

class ValidationResult
{
    private bool $success;
    private string $message;

    public function __construct(bool $success, string $message = '')
    {
        $this->success = $success;
        $this->message = $message;
    }

    public function wasSuccessful()
    {
        return $this->success;
    }

    public function getMessage()
    {
        return $this->message;
    }
}