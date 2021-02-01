<?php
declare(strict_types=1);

namespace Controller\Action;

use Factory\TwigFactory;
use Service\Serializer;
use Twig\Environment;
use Validation\ValidationResult;

abstract class AbstractRESTController extends AbstractController implements ActionInterface
{
    protected Serializer $serializer;
    protected Environment $twig;

    public function __construct(
        \Session $session,
        \Request $request
    ) {
        parent::__construct($session, $request);
        $this->serializer = new Serializer();
        $this->twig = TwigFactory::create();
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

    public function response(
        string $html = null,
        bool $success = true,
        string $message = 'Action executed successfully'
    ) : string
    {
        $response = [
            'success' => $success,
            'message' => $message
        ];

        if($html) {
            $response['html'] = $html;
        }

        return $this->serializer->serialize($response);
    }
}