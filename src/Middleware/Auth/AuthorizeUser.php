<?php 

namespace Base\Middleware\Auth;

use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthorizeUser implements MiddlewareInterface
{

  public function process(ServerRequestInterface $req, 
                          RequestHandlerInterface $handler): ResponseInterface 
  {
    // TODO get all user_group names from db
    if (isset($_SESSION['user_id']) && isset($_SESSION['user_group'])) {
      if ($_SESSION['user_id'] > 0 && 
          in_array(strtolower($_SESSION['user_group']), ['admin', 'user'])
      ) {
        // Authorized
        return $handler->handle($req);
      }
    }
    $_SESSION['destination'] = BASE_URL. ltrim($_SERVER['REQUEST_URI'], '/');
    $_SESSION['login_arr']['error'] = "Not authorized.";
    return new RedirectResponse(BASE_URL. 'admin/login', 302);
  }

}