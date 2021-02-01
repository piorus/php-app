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
    const REQUIRE_LOGGED_IN_USER = true;

    public function executeRESTAction(): string
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
        $commentId = $swipeCommentRepository->save($swipeComment);
        $swipeComment->setId($commentId);

        $html = $this->twig->render('swipecomment/swipecomment.twig', [
            'isAdmin' => $this->session->getUser()->isAdmin(),
            'loggedInUserId' => $this->session->getUser()->getId(),
            'comment' => $swipeComment
        ]);

        return $this->response($html);
    }
}