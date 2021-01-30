<?php
declare(strict_types=1);

namespace Controller\Action;

abstract class AbstractBackendController extends AbstractController implements PostActionInterface
{
    abstract protected function executeBackendAction();

    public function execute()
    {
        $this->validatePermissions(self::ACTION_REDIRECT);
        $this->executeBackendAction();
    }
}