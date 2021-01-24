<?php
declare(strict_types=1);

namespace Controller\Author;

use Controller\AbstractFrontendController;
use Controller\Action\GetActionInterface;

class ViewList extends AbstractFrontendController implements GetActionInterface
{

    public function execute()
    {
        var_dump('authors');die;
    }
}