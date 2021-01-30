<?php
declare(strict_types=1);

namespace Service;

use Exception\FileUploadException;

class FileUpload
{
    const FILE_SIZE_MB = 1000000;
    const DEFAULT_MAX_FILE_SIZE = 5 * self::FILE_SIZE_MB;
    const DEFAULT_ALLOWED_MIME_TYPES = [
        'image/bmp',
        'image/gif',
        'image/jpeg',
        'image/png'
    ];

    public function execute(
        array $file,
        string $uploadDir,
        array $allowedMimeTypes = self::DEFAULT_ALLOWED_MIME_TYPES,
        int $maximumSize = self::DEFAULT_MAX_FILE_SIZE
    ) {
        if (!in_array($file['type'], $allowedMimeTypes)) {
            throw new FileUploadException('Not allowed mime-type.');
        }

        if($file['size'] > $maximumSize) {
            throw new FileUploadException('File is too large.');
        }

        $uploadDir = ROOT_DIR . "pub/uploads/" . trim($uploadDir, '/');

        if(!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $extension = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
        $hasher = new Hasher();
        $filename = "$uploadDir/{$hasher->randomHash()}.$extension";

        if(move_uploaded_file($file['tmp_name'], $filename)) {
            return $filename;
        } else {
            throw new FileUploadException('Moving failed, are file permissions correctly set?');
        }
    }
}