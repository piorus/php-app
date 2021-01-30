<?php
declare(strict_types=1);

namespace Controller\SwipeComment\REST;

use Controller\Action\AbstractRESTController;
use Controller\Action\PostActionInterface;
use Factory\RepositoryFactory;
use Model\SwipeComment;
use Repository\SwipeCommentRepository;

class Create extends AbstractRESTController implements PostActionInterface
{
    public function executeRESTAction()
    {
        $swipeId = $this->request->get('swipeId');
        $comment = $this->request->get('comment');
        $userId = $this->session->getUser()->getId();

        $swipeComment = new SwipeComment([
            'userId' => $userId,
            'swipeId' => $swipeId,
            'comment' => $comment
        ]);

        /** @var SwipeCommentRepository $swipeCommentRepository */
        $swipeCommentRepository = RepositoryFactory::create(SwipeCommentRepository::class);
        $swipeCommentRepository->save($swipeComment);

        return $this->serializer->serialize([
            'success' => true,
            'message' => 'Comment added successfully.',
            'commentId' =>1
        ]);
    }
}