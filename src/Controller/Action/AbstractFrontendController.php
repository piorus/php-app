<?php
declare(strict_types=1);

namespace Controller\Action;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractFrontendController extends AbstractController implements GetActionInterface
{
    /** @var Environment */
    protected $twig;
    /** @var string */
    protected $template = '';
    /** @var \Session */
    protected $session;

    public function __construct(\Session $session, \Request $request)
    {
        parent::__construct($session, $request);

        $this->twig = new Environment(
            new FilesystemLoader(SRC_DIR . 'view')
//            [
//                'cache' => CACHE_DIR . 'twig',
//            ]
        );
    }

    public function getTemplateData() : array
    {
        return [];
    }

    public function execute()
    {
        $this->validatePermissions(self::ACTION_REDIRECT);
        $this->render($this->getTemplateData());
    }

    protected function render(array $templateData)
    {
        $templateData['errors'] = $this->session->getErrorMessages();
        if(static::REQUIRE_LOGGED_IN_USER) {
            $templateData['isAdmin'] = $this->session->getUser()->isAdmin();
        }

        echo $this->twig->render($this->template, $templateData);
    }
}