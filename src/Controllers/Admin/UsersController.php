<?php 

namespace Base\Controllers\Admin;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Response\RedirectResponse;
use Base\Services\Users\Register;

class UsersController {

  private $req;
  private $screener;
  private $registerSvc;

  public function __construct(ServerRequest $req) {
    global $container;
    $this->req = $req;
    $this->screener = $container->get('screener');
    $this->registerSvc = $container->get(Register::class);
  }

  public function login(): ResponseInterface {
    $login_arr = isset($_SESSION['login_arr']) ? $_SESSION['login_arr'] : array();
    $resp = new Response\HtmlResponse('');
    $resp->getBody()->write(
      $this->screener->render('admin/login.html', [
        'login_arr' => $login_arr
      ])
    );
    $_SESSION['login_arr'] = [];
    return $resp;
  }

  public function login_post(): ResponseInterface {
    return new RedirectResponse(BASE_URL. 'admin/login', 302);
  }

  public function register(): ResponseInterface {
    $reg_arr = isset($_SESSION['reg_arr']) ? $_SESSION['reg_arr'] : array();
    $resp = new Response\HtmlResponse('');
    $resp->getBody()->write(
      $this->screener->render('admin/register.html', [
        'reg_arr' => $reg_arr
      ])
    );
    unset($_SESSION['reg_arr']);
    return $resp;
  }

  public function register_post(): ResponseInterface {
    $inp_arr = $this->req->getParsedBody();
    $reg_arr = $this->registerSvc->save_user($inp_arr);
    $_SESSION['reg_arr'] = $reg_arr;
    return new RedirectResponse(BASE_URL. 'admin/register', 302);
  }

  public function logout(): ResponseInterface {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_group']);
    unset($_SESSION['destination']);
    unset($_SESSION['login_arr']);
    return new RedirectResponse(BASE_URL. 'admin/login', 302);
  }

}