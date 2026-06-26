<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . str_replace('/', DIRECTORY_SEPARATOR, $path);

if ($path !== '/' && is_file($file)) {
    return false;
}

if (preg_match('/^\/([A-Za-z0-9_-]+)\.php$/', $path, $matches)) {
    $_GET['pagename'] = $matches[1];
}

require __DIR__ . '/index.php';
