<?php 
if (!isset($container)) throw(new ErrorException('Routes undefined.'));

use Base\Controllers\Admin\AdminController;
use Base\Middleware\Auth\AuthorizeAdmin;
use League\Route\RouteGroup;

$router->group('/admin', function (RouteGroup $route) {

  $route->map('GET', 'dashboard', 
    [AdminController::class, 'dashboard']
  );

  $route->map('GET', '/', 
    [AdminController::class, 'dashboard']
  );

  $route->map('GET', '', 
    [AdminController::class, 'dashboard']
  );
  
})->middleware(new AuthorizeAdmin);