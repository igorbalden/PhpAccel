<?php 

use Doctrine\DBAL\DriverManager;
use Psr\Log\LoggerInterface;
use Laminas\Diactoros\ServerRequestFactory;
use League\Route\Strategy\ApplicationStrategy;
use League\Route\Router;

global $logger;
return [

  // Router
  \League\Route\Router::class => \DI\Factory(function() {
    $router = new Router();
    return $router;
  }),

  // Request
  \Laminas\Diactoros\ServerRequestFactory::class => \DI\factory(function() {
    return \Laminas\Diactoros\ServerRequestFactory::fromGlobals(
        $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
    );
  }),
  \Laminas\Diactoros\ServerRequest::class => 
    \DI\get(\Laminas\Diactoros\ServerRequestFactory::class),

  // PDO connection
  'dbdefault' => DI\factory(function() {
    $connectionParams = array(
      'url' => 'sqlite:///'. __DIR__. '/phpacceldb-test.sqlite',
    );
    $conn = DriverManager::getConnection($connectionParams);
    return $conn;
  }),

  LoggerInterface::class => $logger,
  
];

