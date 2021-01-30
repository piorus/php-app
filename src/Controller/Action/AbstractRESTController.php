<?php
declare(strict_types=1);

namespace Controller\Action;

use Service\Serializer;
use Validation\ValidationResult;

abstract class AbstractRESTController extends AbstractController implements ActionInterface
{
    protected Serializer $serializer;

    public function __construct(
        \Session $session,
        \Request $request
    ) {
        parent::__construct($session, $request);
        $this->serializer = new Serializer();
    }

    abstract public function executeRESTAction();

    public function execute()
    {
        /** @var ValidationResult $validationResult */
        $validationResult = $this->validatePermissions(self::ACTION_RETURN_VALIDATION_RESULT);

        if(!$validationResult->wasSuccessful()) {
            echo $this->serializer->serialize([
                'error' => true,
                'message' => $validationResult->getMessage()
            ]);
        }

        header('Content-Type: application/json');
        echo $this->executeRESTAction();
    }
}