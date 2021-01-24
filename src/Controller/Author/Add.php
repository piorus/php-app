<?php
declare(strict_types=1);

namespace Controller\Author;

use Controller\AbstractFrontendController;
use Controller\Action\GetActionInterface;

class Add extends AbstractFrontendController implements GetActionInterface
{
    protected $template = 'author/add.twig';
}