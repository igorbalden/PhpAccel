<?php 

namespace Base\Middleware\Auth;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\RedirectResponse;

class ForwardAuthd implements MiddlewareInterface
{
  public function process(ServerRequestInterface $req, 
                          RequestHandlerInterface $handler): ResponseInterface 
  {
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0) {
      $destination = BASE_URL. 'api/show/Validation';
      if (strtolower($_SESSION['user_group']) === 'admin') {
        $destination = BASE_URL. 'admin/dashboard';
      }
      if (isset($_SESSION['destination'])) {
        $destination = $_SESSION['destination'];
        unset($_SESSION['destination']);
      }
      return new RedirectResponse($destination, 302);
    }
    return $handler->handle($req);
  }
}