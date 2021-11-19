<?php 

use Monolog\Logger;
use DI\ContainerBuilder;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequest;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\Router;
use League\Route\Http\Exception;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

// Error handling
if (strtolower($_ENV['APP_ENVIRONMENT']) === 'development') {
  ini_set('display_errors', 'on');
  $log_level = Logger::DEBUG;
} else {
  ini_set('display_errors', 'off');
  $log_level = Logger::ERROR;
}

// Logger
$logger = new Logger('debLogger');
$stream = 
  new RotatingFileHandler(ROOT_PATH. 'logs/debug.log', 0, $log_level, true, 0664);
$stream->setFormatter(new LineFormatter(
  "%datetime% > %message%\n", "Y-m-d H:i:s", TRUE));
$logger->pushHandler($stream);
require_once(ROOT_PATH. 'src/Errors/error_handler.php');

// Container
$containerBuilder = new ContainerBuilder();
if ($_ENV['APP_ENVIRONMENT'] === 'production') {
  $containerBuilder->enableCompilation(ROOT_PATH . 'logs/tmp/');
  $containerBuilder->writeProxiesToFile(true, ROOT_PATH . 'logs/tmp/');
}
$containerBuilder->useAutowiring(true);
$containerBuilder->useAnnotations(true);
$containerBuilder->addDefinitions(__DIR__ . '/config.php');
$container = $containerBuilder->build();

// Request
$router = $container->get(Router::class);
require_once 'routes.php';
$req = $container->get(ServerRequest::class);

// Response
try {
  $resp = $router->dispatch($req);
} catch(Exception\NotFoundException $e) {
  $resp = new Response\HtmlResponse('Error 404. "'. 
    htmlentities($req->getServerParams()['REQUEST_URI'], ENT_QUOTES). '" not found.');
  $resp = $resp->withStatus(404);
} catch(Exception\MethodNotAllowedException $e) {
  $resp = new Response\EmptyResponse(405);
}
$runner = new SapiEmitter();
$runner->emit($resp);
