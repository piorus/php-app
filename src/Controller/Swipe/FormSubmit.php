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

    protected ?string $entityClass = Swipe::class;
    protected ?string $repositoryClass = SwipeRepository::class;
    protected string $redirectPath = '/swipes';

    /** @param Swipe $swipe */
    public function beforeSave(EntityInterface $swipe)
    {
        $uploader = new FileUpload();

        $file = $this->request->getFile('file');

        // bail early if swipe already exist and no file was added
        if($swipe->getId() && empty($file['type'])) {
            return;
        }

        try {
            $filePath = $uploader->execute(
                $file,
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