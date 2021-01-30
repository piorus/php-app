<?php
declare(strict_types=1);

namespace Controller\Author;

use Controller\Action\AbstractFrontendController;

class ViewSingle extends AbstractFrontendController
{
    protected $template = 'author/single.twig';
}