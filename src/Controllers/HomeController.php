<?php 

namespace Base\Controllers;

use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;

class HomeController {
  
  private $screener;

  public function __construct() {
    global $container;
    $this->screener = $container->get('screener');
  }

  public function home(ServerRequestInterface $req): ResponseInterface {
    $login_arr = isset($_SESSION['login_arr']) ? $_SESSION['login_arr'] : array();
    $resp = new Response\HtmlResponse('');
    $resp->getBody()->write(
      $this->screener->render('home.html', ['login_arr' => $login_arr])
    );
    $_SESSION['login_arr'] = [];
    return $resp;
  }
  
}