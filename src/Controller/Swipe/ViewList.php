<?php
declare(strict_types=1);

namespace Controller\Swipe;

use Controller\Action\AbstractViewListController;
use Model\Swipe;
use Repository\SwipeRepository;

class ViewList extends AbstractViewListController
{
    protected $template = 'swipe/list.twig';
    /** @var string|null */
    protected $repositoryClass = SwipeRepository::class;
    /** @var string|null */
    protected $entity = Swipe::ENTITY;
}