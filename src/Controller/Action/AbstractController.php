<?php
declare(strict_types=1);

namespace Controller\Action;

abstract class AbstractController
{
    const REQUIRE_LOGGED_IN_USER = false;
    const REQUIRE_LOGGED_IN_ADMIN_USER = false;

    const ACTION_REDIRECT = 'redirect';
    const ACTION_RETURN_BOOLEAN = 'return_boolean';
    const ACTION_RETURN_VALIDATION_RESULT = 'return_validation_result';

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

    private function handleValidationError(string $action, string $message, string $redirectPath)
    {
        switch ($action) {
            case self::ACTION_REDIRECT:
                $this->session->addErrorMessage($message);
                $this->redirect($redirectPath);
                break;
            case self::ACTION_RETURN_VALIDATION_RESULT:
                return new \Validation\ValidationResult(false, $message);
            case self::ACTION_RETURN_BOOLEAN:
                return false;
        }

        return false;
    }

    protected function validatePermissions(string $action = self::ACTION_RETURN_BOOLEAN)
    {
        if (
            (static::REQUIRE_LOGGED_IN_USER || static::REQUIRE_LOGGED_IN_ADMIN_USER) &&
            !$this->session->isLoggedIn()
        ) {
            return $this->handleValidationError(
                $action,
                'Log in required.',
                '/login'
            );
        }

        if (static::REQUIRE_LOGGED_IN_ADMIN_USER && !$this->session->getUser()->isAdmin()) {
            return $this->handleValidationError(
                $action,
                'Nay. This section is for admins only.',
                '/'
            );
        }

        switch ($action) {
            case self::ACTION_RETURN_VALIDATION_RESULT:
                return new \Validation\ValidationResult(true, 'OK');
            default:
                return true;
        }
    }
}