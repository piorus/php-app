<?php
declare(strict_types=1);

namespace Controller\Swipe;

use Controller\Action\AbstractViewSingleController;
use Database\Search\SearchCriteriaBuilder;
use Factory\RepositoryFactory;
use Model\Swipe;
use Repository\SwipeCommentRepository;
use Repository\SwipeRepository;

class ViewSingle extends AbstractViewSingleController
{
    protected string $template = 'swipe/layout/single.twig';
    protected ?string $repositoryClass = SwipeRepository::class;
    protected ?string $entity = Swipe::ENTITY;

    public function getTemplateData(): array
    {
        $templateData = parent::getTemplateData();

        $builder = new SearchCriteriaBuilder();
        $builder->addFilter('swipe_id', (int) $this->request->get('id'));

        /** @var SwipeCommentRepository $swipeCommentRepository */
        $swipeCommentRepository = RepositoryFactory::create(SwipeCommentRepository::class);
        $templateData['comments'] = $swipeCommentRepository->getList($builder->build());

        return $templateData;
    }
}