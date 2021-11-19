<?php 
if (!isset($container)) throw(new ErrorException('Routes undefined.'));

use League\Route\RouteGroup;
use Base\Middleware\Auth\LoginValidation;
use Base\Middleware\Auth\Authentication;
use Base\Middleware\Auth\ForwardAuthd;
use Base\Controllers\Admin\UsersController;

$router->group('/admin', function (RouteGroup $route) {

  $route->map('GET', 'login', 
    [UsersController::class, 'login']
  ) ->middleware(new ForwardAuthd);

  $route->map('POST', 'login-post', 
    [UsersController::class, 'login_post']
  ) ->middleware(new LoginValidation)
    ->middleware(new Authentication);

  $route->map('GET', 'register', 
    [UsersController::class, 'register']
  );

  $route->map('POST', 'register-post', 
    [UsersController::class, 'register_post']
  );

  $route->map('GET', 'logout', 
    [UsersController::class, 'logout']
  );
  
});