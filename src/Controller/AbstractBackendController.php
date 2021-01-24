<?php
declare(strict_types=1);

namespace Controller;

use Controller\Action\ActionInterface;

abstract class AbstractBackendController extends AbstractController implements ActionInterface
{
}