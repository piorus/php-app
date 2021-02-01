<?php
declare(strict_types=1);

namespace Controller\Action;

use Factory\TwigFactory;
use Twig\Environment;

abstract class AbstractFrontendController extends AbstractController implements GetActionInterface
{
    protected Environment $twig;
    protected string $template = '';
    protected \Session $session;
    protected string $pageTitle = 'Page';

    public function __construct(\Session $session, \Request $request)
    {
        parent::__construct($session, $request);

        $this->twig = TwigFactory::create();
    }

    protected function addPageTitle(array $templateData): array
    {
        return array_merge(
            $templateData,
            ['title' => $this->pageTitle]
        );
    }

    public function getTemplateData(): array
    {
        return [];
    }

    public function execute()
    {
        $this->validatePermissions(self::ACTION_REDIRECT);
        $templateData = $this->addPageTitle($this->getTemplateData());
        $templateData['loggedInUserId'] = $this->session->get(\Session::KEY_USER_ID);
        $this->render($templateData);
    }

    protected function render(array $templateData)
    {
        $templateData['errors'] = $this->session->getErrorMessages();
        if (static::REQUIRE_LOGGED_IN_USER) {
            $templateData['isAdmin'] = $this->session->getUser()->isAdmin();
        }

        echo $this->twig->render($this->template, $templateData);
    }
}