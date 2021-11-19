<?php 

namespace Base\Middleware\Auth;

use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthorizeAdmin implements MiddlewareInterface
{

  public function process(ServerRequestInterface $req, 
                          RequestHandlerInterface $handler): ResponseInterface 
  {
    if (isset($_SESSION['user_id']) && isset($_SESSION['user_group'])) {
      if ($_SESSION['user_id'] > 0 && strtolower($_SESSION['user_group']) === 'admin'
      ) {
        // Authorized
        return $handler->handle($req);
      }
      // Authenticated, not Admin
      $_SESSION['login_arr']['error'] = "Must be admin.";
      return new RedirectResponse(BASE_URL, 302);
    }
    $_SESSION['destination'] = BASE_URL. ltrim($_SERVER['REQUEST_URI'], '/');
    $_SESSION['login_arr']['error'] = "Not Authorized.";
    return new RedirectResponse(BASE_URL. 'admin/login', 302);
  }

}