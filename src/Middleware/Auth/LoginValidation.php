<?php 

namespace Base\Middleware\Auth;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\RedirectResponse;

class LoginValidation implements MiddlewareInterface
{
  public function process(ServerRequestInterface $req, 
                          RequestHandlerInterface $handler): ResponseInterface 
  {
    $_SESSION['login_arr'] = array();
    $inp_arr = $req->getParsedBody();
    if (!$inp_arr['email'] || !$inp_arr['password']) {
      $_SESSION['login_arr']['error'] = "All inputs are required.";
      if (strtolower(substr($_SERVER['HTTP_REFERER'], -11)) !== 'admin/login' &&
          !isset($_SESSION['destination'])
      ) {
        $_SESSION['destination'] = $_SERVER['HTTP_REFERER'];
      }
      return new RedirectResponse(BASE_URL. 'admin/login', 302);
    }
    return $handler->handle($req);
  }
}