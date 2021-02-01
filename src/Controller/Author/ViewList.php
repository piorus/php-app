<?php
declare(strict_types=1);

namespace Controller\Author;

use Controller\Action\AbstractViewListController;
use Model\Author;
use Repository\AuthorRepository;

class ViewList extends AbstractViewListController
{
    protected string $template = 'author/layout/list.twig';
    protected ?string $repositoryClass = AuthorRepository::class;
    protected ?string $entity = Author::ENTITY;
    protected string $pageTitle = 'Authors';
}