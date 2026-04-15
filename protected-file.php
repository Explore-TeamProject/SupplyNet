<?php
session_start();

$publicFiles = [
    'logo.png',
    'DhaneshwarMardi.jpg',
    'AbhijitSahooabhi.jpeg',
    'PikeshRoul.jpeg',
    'DebadataRout.jpeg',
    'PabitraOjha.png'
];

$requestedPath = isset($_GET['path']) ? $_GET['path'] : '';
$requestedPath = trim($requestedPath, "\/\\");

if ($requestedPath === '' || strpos($requestedPath, '..') !== false) {
    http_response_code(403);
    $_GET['code'] = 403;
    include 'error.php';
    exit;
}

$uploadsDir = realpath(__DIR__ . '/uploads');
$filePath = realpath($uploadsDir . DIRECTORY_SEPARATOR . $requestedPath);

if (!$filePath || strpos($filePath, $uploadsDir) !== 0 || !is_file($filePath)) {
    http_response_code(404);
    $_GET['code'] = 404;
    include 'error.php';
    exit;
}

$basename = basename($filePath);
$authorized = isset($_SESSION['UserID']) || in_array($basename, $publicFiles, true);

if (!$authorized) {
    http_response_code(401);
    $_GET['code'] = 401;
    include 'error.php';
    exit;
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$contentType = $finfo ? finfo_file($finfo, $filePath) : mime_content_type($filePath);
if ($finfo) {
    finfo_close($finfo);
}

$allowedContentTypes = [
    'image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/webp',
    'application/pdf', 'text/plain', 'text/csv', 'application/zip'
];

if (!in_array($contentType, $allowedContentTypes, true)) {
    $contentType = 'application/octet-stream';
}

header('Content-Type: ' . $contentType);
header('Content-Length: ' . filesize($filePath));
header('Content-Disposition: inline; filename="' . basename($filePath) . '"');
header('Cache-Control: private, max-age=86400');
readfile($filePath);
exit;
