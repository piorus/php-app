<?php
declare(strict_types=1);

namespace Controller;

abstract class AbstractController
{
    /** @var \Session */
    protected $session;
    /** @var \Request */
    protected $request;

    public function __construct(\Session $session, \Request $request)
    {
        $this->session = $session;
        $this->request = $request;
    }

    public function redirect(string $path)
    {
        header("Location: $path");
        die;
    }
}