<?php 

namespace Base\Middleware\Auth;

use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Base\Services\Users\Auth;

class Authentication implements MiddlewareInterface
{
  private $authSvc;

  public function __construct() {
    global $container;
    $this->authSvc = $container->get(Auth::class);
  }

  public function process(ServerRequestInterface $req, 
                          RequestHandlerInterface $handler): ResponseInterface 
  {
    if (isset($_SESSION['user_id']) && isset($_SESSION['user_group'])) {
      if ($_SESSION['user_id'] > 0 && 
          in_array(strtolower($_SESSION['user_group']), ['admin', 'user'])
      ) {
        // Authenticated already
        return $handler->handle($req);
      }
    }
    $_SESSION['login_arr'] = array();
    $inp_arr = $req->getParsedBody();
    $auth_arr = $this->authSvc->login($inp_arr);
    if (isset($auth_arr['error'])) {
      // Not Authenticated
      $_SESSION['login_arr']['error'] = $auth_arr['error'];
      return new RedirectResponse(BASE_URL. 'admin/login', 302);
    }
    // Authenticate user
    $_SESSION['user_id'] = $auth_arr['id'];
    $_SESSION['user_group'] = $auth_arr['group'];
    return $handler->handle($req);
  }

}