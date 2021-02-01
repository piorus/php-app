<?php
declare(strict_types=1);

namespace Controller\Swipe;

use Controller\Action\AbstractViewListController;
use Model\Swipe;
use Repository\SwipeRepository;

class ViewList extends AbstractViewListController
{
    protected string $template = 'swipe/layout/list.twig';
    protected ?string $repositoryClass = SwipeRepository::class;
    protected ?string $entity = Swipe::ENTITY;
    protected string $pageTitle = 'Swipes';
}