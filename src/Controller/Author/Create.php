<?php
declare(strict_types=1);

namespace Controller\Author;

use Controller\AbstractFrontendController;
use Controller\Action\GetActionInterface;

class Create extends AbstractFrontendController implements GetActionInterface
{
    protected $template = 'author/create.twig';
}