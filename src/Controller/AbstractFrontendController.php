<?php
declare(strict_types=1);

namespace Controller;

use Controller\Action\ActionInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractFrontendController extends AbstractController implements ActionInterface
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

    public function execute()
    {
        $this->render([]);
    }

    protected function render(array $data)
    {
        echo $this->twig->render($this->template, $data);
    }
}