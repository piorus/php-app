<?php
declare(strict_types=1);

namespace Controller\Author;

use Controller\Action\AbstractFormSubmitController;
use Model\Author;
use Repository\AuthorRepository;

class FormSubmit extends AbstractFormSubmitController
{
    protected ?string $entityClass = Author::class;
    protected ?string $repositoryClass = AuthorRepository::class;
    protected string $redirectPath = '/authors';
}