<?php 

namespace Base\Controllers\Admin;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\ServerRequest;
use Base\Services\Users\ListUsers;

class AdminController {

  private $screener;
  private $list_users;

  public function __construct() {
    global $container;
    $this->list_users = $container->get(ListUsers::class);
    $this->screener = $container->get('screener');
  }

  public function dashboard(ServerRequest $req): ResponseInterface {
    $users_arr = $this->list_users->list_all();
    $resp = new Response\HtmlResponse('');
    $resp->getBody()->write(
      $this->screener->render('admin/dashboard.html', [
        // 'hereVar' => print_r($req, true),
        'users_arr' => $users_arr,
      ])
    );
    return $resp;
  }

}