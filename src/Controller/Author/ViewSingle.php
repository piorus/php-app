<?php
declare(strict_types=1);

namespace Controller\Author;

use Controller\Action\AbstractViewSingleController;
use Model\Author;
use Repository\AuthorRepository;

class ViewSingle  extends AbstractViewSingleController
{
    protected string $template = 'author/layout/single.twig';
    protected ?string $repositoryClass = AuthorRepository::class;
    protected ?string $entity = Author::ENTITY;

    protected function addPageTitle(array $templateData): array
    {
        /** @var Author $author */
        $author = $templateData[$this->entity] ?? null;
        $templateData['title'] = 'Author';

        if($author) {
            $templateData['title'] = sprintf(
                '%s %s',
                $author->getFirstName(),
                $author->getLastName()
            );
        }

        return $templateData;
    }
}