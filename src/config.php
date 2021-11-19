<?php 

use Doctrine\DBAL\DriverManager;
use Psr\Log\LoggerInterface;
use Laminas\Diactoros\ServerRequestFactory;
use League\Route\Strategy\ApplicationStrategy;
use League\Route\Router;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

global $logger;

return [

  LoggerInterface::class => $logger,

  // Request
  \Psr\Http\Message\ServerRequestInterface::class => \DI\factory(function() {
    $req = \Laminas\Diactoros\ServerRequestFactory::fromGlobals(
        $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
    );
    return $req;
  }),
  \Laminas\Diactoros\ServerRequest::class => 
    \DI\get(\Psr\Http\Message\ServerRequestInterface::class),

  // Router
  \League\Route\Router::class => 
    \DI\Factory(function(\Psr\Container\ContainerInterface $cont) {
      $strategy = new ApplicationStrategy();
      $strategy->setContainer($cont);
      $router = new Router();
      $router->setStrategy($strategy);
      return $router;
    }),

  // MySQL PDO connection
  'dbdefault' => DI\factory(function() {
    // $connectionParams = array(
    //   'dbname' => $_ENV['SQL_DBNAME'],
    //   'user' => $_ENV['SQL_USER'],
    //   'password' => $_ENV['SQL_PASSWORD'],
    //   'host' => $_ENV['SQL_HOST'],
    //   'driver' => $_ENV['SQL_DRIVER'],
    // );

    $connectionParams = array(
      'url' => 'sqlite:///'. ROOT_PATH. $_ENV['SQL_DBNAME'],
    );

    $conn = DriverManager::getConnection($connectionParams);
    return $conn;
  }),

  'screener' => \DI\factory(function() {
    $debug = $_ENV['APP_ENVIRONMENT'] === 'production' ? false : true;
    $loader = new FilesystemLoader(ROOT_PATH. '/src/Templates');
    $twig = new Environment($loader, [
        // 'cache' => ROOT_PATH. '/logs/twig/cache',
        'cache' => false,
        'debug' => $debug,
    ]);
    $twig->addGlobal('session', $_SESSION);
    $twig->addExtension(new \Twig\Extension\DebugExtension());
    return $twig;
  }),
  
];

