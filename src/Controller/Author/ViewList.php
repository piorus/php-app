<?php
declare(strict_types=1);

namespace Controller\Author;

use Controller\Action\AbstractViewListController;
use Model\Author;
use Repository\AuthorRepository;

class ViewList extends AbstractViewListController
{
    protected $template = 'author/list.twig';
    /** @var string|null */
    protected $repositoryClass = AuthorRepository::class;
    /** @var string|null */
    protected $entity = Author::ENTITY;
}