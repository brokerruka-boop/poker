<?php
function ops_env_first($names, $default = '')
{
    foreach ($names as $name) {
        $value = getenv($name);

        if ($value !== false && $value !== '') {
            return $value;
        }
    }

    return $default;
}

$databaseUrl = getenv('MYSQL_URL') ?: getenv('DATABASE_URL');
$envHost = ops_env_first(array('DB_SERVER', 'MYSQL_HOST', 'MYSQLHOST'));
$envPort = ops_env_first(array('DB_PORT', 'MYSQL_PORT', 'MYSQLPORT'));
$envUser = ops_env_first(array('DB_SERVER_USERNAME', 'MYSQL_USER', 'MYSQLUSER', 'MYSQL_USERNAME'));
$envPass = ops_env_first(array('DB_SERVER_PASSWORD', 'MYSQL_PASSWORD', 'MYSQLPASSWORD'));
$envName = ops_env_first(array('DB_DATABASE', 'MYSQL_DATABASE', 'MYSQLDATABASE', 'MYSQL_DB'));
$hasEnvConfig = $databaseUrl || $envHost || $envUser || $envPass || $envName;
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
    define('DB_SERVER', $envHost . (($envHost && $envPort) ? ';port=' . $envPort : ''));
    define('DB_SERVER_USERNAME', $envUser);
    define('DB_SERVER_PASSWORD', $envPass);
    define('DB_DATABASE', $envName);
}
