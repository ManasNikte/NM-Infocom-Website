<?php
/**
 * Safe handling of files uploaded through the CRM (event images, product covers, catalogues).
 * Files land under the site's uploads/ folder, whose .htaccess blocks script execution.
 */

const CRM_UPLOAD_ROOT = __DIR__ . '/../../uploads';

const CRM_IMAGE_TYPES = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
const CRM_PDF_TYPES = ['application/pdf' => 'pdf'];

/**
 * Validates an entry from $_FILES by its content and stores it as uploads/<subdir>/<prefix><random>.<ext>.
 * The extension comes from the detected MIME type, never from the client's filename.
 *
 * @param array $allowed MIME type => extension
 * @return string filename (without directory)
 * @throws RuntimeException with a user-presentable message
 */
function crm_store_upload(array $file, $subdir, $prefix, array $allowed, $maxBytes) {
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'])) {
        throw new RuntimeException('File upload failed.');
    }
    if ($file['size'] > $maxBytes) {
        throw new RuntimeException('File is larger than ' . round($maxBytes / 1048576) . ' MB.');
    }
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    if (!isset($allowed[$mime])) {
        throw new RuntimeException('Unsupported file type. Allowed: ' . implode(', ', array_unique($allowed)) . '.');
    }
    if (str_starts_with($mime, 'image/') && @getimagesize($file['tmp_name']) === false) {
        throw new RuntimeException('The file is not a valid image.');
    }

    $dir = CRM_UPLOAD_ROOT . '/' . trim($subdir, '/');
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
        throw new RuntimeException('Upload folder is not available.');
    }
    $name = $prefix . bin2hex(random_bytes(8)) . '.' . $allowed[$mime];
    if (!move_uploaded_file($file['tmp_name'], "$dir/$name")) {
        throw new RuntimeException('Could not save the uploaded file.');
    }
    chmod("$dir/$name", 0644);
    return $name;
}

/**
 * Deletes a previously uploaded file, given the path stored in the database
 * ("uploads/catalogue/x.pdf", "uploads/products/x.png", "x.jpg" + $subdir, ...).
 * Only files inside uploads/<subdir>/ are ever touched.
 */
function crm_delete_upload($storedPath, $subdir) {
    if (!$storedPath) {
        return;
    }
    $base = realpath(CRM_UPLOAD_ROOT . '/' . trim($subdir, '/'));
    $target = $base ? realpath($base . '/' . basename((string) $storedPath)) : false;
    if ($target && str_starts_with($target, $base . DIRECTORY_SEPARATOR) && is_file($target)) {
        unlink($target);
    }
}
