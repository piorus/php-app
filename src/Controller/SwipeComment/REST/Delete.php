<?php
declare(strict_types=1);

namespace Controller\SwipeComment\REST;

use Controller\Action\AbstractRESTController;
use Controller\Action\PostActionInterface;
use Factory\RepositoryFactory;
use Repository\SwipeCommentRepository;

class Delete extends AbstractRESTController implements PostActionInterface
{
    const REQUIRE_LOGGED_IN_USER = true;

    public function executeRESTAction()
    {
        $commentId = (int)$this->request->get('commentId');
        /** @var SwipeCommentRepository $swipeCommentRepository */
        $swipeCommentRepository = RepositoryFactory::create(SwipeCommentRepository::class);
        /** @var SwipeComment $swipeComment */
        $swipeComment = $swipeCommentRepository->get($commentId);
        $user = $this->session->getUser();

        if ($user->getId() !== $swipeComment->getUserId() && !$user->isAdmin()) {
            return $this->response(null, false, 'Incorrect privileges.');
        }

        $swipeCommentRepository->deleteById($commentId);

        return $this->response();
    }
}