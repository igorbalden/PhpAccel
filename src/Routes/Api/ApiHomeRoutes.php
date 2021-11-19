<?php 
if (!isset($container)) throw(new ErrorException('Routes undefined.'));

use League\Route\RouteGroup;
use Base\Controllers\Api\ApiHomeController;
use Base\Middleware\UrlValidation;
use Base\Middleware\Auth\AuthorizeUser;

$router->group('/api', function (RouteGroup $route) {

  $route->map('GET', 'show/{prm}', 
    [ApiHomeController::class, 'show']
  ) ->middleware(new AuthorizeUser)
    ->middleware(new UrlValidation);

});