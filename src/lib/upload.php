<?php

declare(strict_types=1);

require_once __DIR__ . '/validation.php';

/**
 * Uploads an image to the server and returns the file path.
 *
 * @param array $image The image data to be uploaded.
 * @return string The file path of the uploaded image.
 */
function uploadImage(array $image): string
{
    $storagePath = STORAGE_PATH . '/' . uniqid() . '-' . $image['name'];
    move_uploaded_file($image['tmp_name'], $storagePath);

    $filePath = '/src' . explode('src', $storagePath)[1];

    return $filePath;
}
