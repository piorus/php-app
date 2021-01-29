<?php
declare(strict_types=1);

namespace Validator;

class AdminValidator
{
    public function validate(\Session $session)
    {
        return $session->getUser() && $session->getUser()->isAdmin();
    }
}