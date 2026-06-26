<?php
$root = dirname(__DIR__);
chdir($root);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = $root . str_replace('/', DIRECTORY_SEPARATOR, $path);

if ($path !== '/' && is_file($file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
    require $file;
    return;
}

if (preg_match('/^\/([A-Za-z0-9_-]+)\.php$/', $path, $matches)) {
    $_GET['pagename'] = $matches[1];
}

require $root . DIRECTORY_SEPARATOR . 'index.php';
