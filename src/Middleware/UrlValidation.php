<?php 

namespace Base\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UrlValidation implements MiddlewareInterface
{

  public function process(ServerRequestInterface $req, 
                          RequestHandlerInterface $handler): ResponseInterface 
  {
    // Property $pipedVar does not exist in Request object
    // It will be added, and get passed to the controller.
    $req->pipedVar = $req->getAttribute('prm');
    return $handler->handle($req);
  }

}