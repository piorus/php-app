<?php
declare(strict_types=1);

class Request
{
    private array $data = [];

    public function __construct(string $method)
    {
        $this->data = $method === 'GET' ? $_GET : $_POST;
    }

    public function get(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return isset($this->data[$key]);
    }

    public function getAll(): array
    {
        return $this->data;
    }

    public function getFile(string $name) : ?array
    {
        return $_FILES[$name] ?? null;
    }
}