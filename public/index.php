<?php 

session_start();
$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);
if ($uri !== '/' && file_exists(__DIR__. $uri)) {
    return false;
}

const ROOT_PATH = __DIR__. '/../';
require_once ROOT_PATH. "vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
$dotenv->safeLoad();

if ($_ENV['BASE_URL']) {
    $_ENV['BASE_URL'] = trim($_ENV['BASE_URL']);
    if (substr($_ENV['BASE_URL'], -1) !== "/") $_ENV['BASE_URL'] .= "/";
    define('BASE_URL', $_ENV['BASE_URL']);
    if ($_ENV['BASE_URL'] !== '/') {
        $_SERVER['REQUEST_URI'] = 
            substr($_SERVER['REQUEST_URI'], (strlen($_SERVER['BASE_URL'])));
    }
} else {
    die('BASE_URL must be set in .env .');
}

// CORS
if (isset($_SERVER['HTTP_ORIGIN'])) {
    $origin = $_SERVER['HTTP_ORIGIN'];
    header("Access-Control-Allow-Origin: {$origin}");
    header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    header('Access-Control-Allow-Credentials: true');
}

require_once ROOT_PATH. "src/starter.php";
