<?php
declare(strict_types=1);

namespace Controller\Swipe;

use Controller\Action\AbstractFormSubmitController;
use Exception\FileUploadException;
use Model\EntityInterface;
use Model\Swipe;
use Repository\SwipeRepository;
use Service\ConvertFilePathToUrl;
use Service\FileUpload;

class FormSubmit extends AbstractFormSubmitController
{
    const UPLOAD_DIR = 'swipes';

    /** @var string|null */
    protected $entityClass = Swipe::class;
    /** @var string|null */
    protected $repositoryClass = SwipeRepository::class;
    /** @var string */
    protected $redirectPath = '/swipes';

    /** @var Swipe $entity */
    public function beforeSave(EntityInterface $swipe)
    {
        $uploader = new FileUpload();

        try {
            $filePath = $uploader->execute(
                $this->request->getFile('file'),
                self::UPLOAD_DIR
            );
        } catch (FileUploadException $e) {
            $this->session->addErrorMessage($e->getMessage());
            $this->redirect($this->redirectPath);
        }

        $pathConverter = new ConvertFilePathToUrl();
        $swipe->setFileUrl("/{$pathConverter->execute($filePath)}");
    }
}