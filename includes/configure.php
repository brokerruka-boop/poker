<?php
$databaseUrl = getenv('MYSQL_URL') ?: getenv('DATABASE_URL');
$hasEnvConfig = $databaseUrl || getenv('DB_SERVER') || getenv('DB_SERVER_USERNAME') || getenv('DB_SERVER_PASSWORD') || getenv('DB_DATABASE');
$localConfigFile = __DIR__ . '/configure.local.php';

if ($databaseUrl && preg_match('/^mysql:\/\//i', $databaseUrl)) {
    $database = parse_url($databaseUrl);

    define('DB_SERVER', $database['host'] . (isset($database['port']) ? ';port=' . $database['port'] : ''));
    define('DB_SERVER_USERNAME', isset($database['user']) ? rawurldecode($database['user']) : '');
    define('DB_SERVER_PASSWORD', isset($database['pass']) ? rawurldecode($database['pass']) : '');
    define('DB_DATABASE', isset($database['path']) ? ltrim($database['path'], '/') : '');
} elseif (!$hasEnvConfig && !getenv('VERCEL') && is_file($localConfigFile)) {
    $localConfig = require $localConfigFile;

    define('DB_SERVER', $localConfig['DB_SERVER']);
    define('DB_SERVER_USERNAME', $localConfig['DB_SERVER_USERNAME']);
    define('DB_SERVER_PASSWORD', $localConfig['DB_SERVER_PASSWORD']);
    define('DB_DATABASE', $localConfig['DB_DATABASE']);
} else {
    define('DB_SERVER', getenv('DB_SERVER') ?: 'localhost');
    define('DB_SERVER_USERNAME', getenv('DB_SERVER_USERNAME') ?: '');
    define('DB_SERVER_PASSWORD', getenv('DB_SERVER_PASSWORD') ?: '');
    define('DB_DATABASE', getenv('DB_DATABASE') ?: '');
}
