<?php 

require_once __DIR__. "/../vendor/autoload.php";

use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\Strategy\ApplicationStrategy;
use League\Route\Http\Exception;
use League\Route\Router;
use DI\ContainerBuilder;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

const ROOT_PATH = __DIR__. '/../';
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
$dotenv->safeLoad();

// log
$logger = new Logger('testLogger');
$stream = new StreamHandler(ROOT_PATH. 'logs/test.log', Logger::DEBUG);
$stream->setFormatter(new LineFormatter(
    "%datetime% > %message%\n", "Y-m-d H:i:s", TRUE));
$logger->pushHandler($stream);
ini_set('display_errors', 'on');
require_once(ROOT_PATH. 'src/Errors/error_handler.php');

// Container
$containerBuilder = new ContainerBuilder;
$containerBuilder->useAutowiring(true);
$containerBuilder->useAnnotations(true);
$containerBuilder->addDefinitions(__DIR__ . '/test-config.php');
$container = $containerBuilder->build();

// DB
$db = $container->get('dbdefault');

// Router
$strategy = new ApplicationStrategy();
$strategy->setContainer($container);
$router = $container->get(\League\Route\Router::class);
$router->setStrategy($strategy);

// Request
$req = ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);
