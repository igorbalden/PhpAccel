<?php 

namespace Base\Controllers;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Base\Services\Contacts\Contacts;

class ContactsController {

  private $conn;
  private $contactsSvc;
  private $screener;

  public function __construct() {
    global $container;
    $this->conn = $container->get('dbdefault');
    $this->contactsSvc = $container->get(Contacts::class);
    $this->screener = $container->get('screener');
  }

  public function contacts(): ResponseInterface {
    // An other option
    // $stmt = $this->conn->prepare($sql);
    // $stmt->bindValue("minid", $minid);
    // $res = $stmt->execute();
    // $contacts_arr = [];
    // while(($r = $res->fetchAssociative()) !== false) {
    //   $contacts_arr[] = $r;
    // }
    $contacts_arr = $this->contactsSvc->get_contacts();
    // API response
    // $resp = new Response\JsonResponse(['contacts' => $contacts_arr]);
    // On screen response
    $resp = new Response();
    $resp->getBody()->write(
      $this->screener->render('contacts.html', ['contacts_arr' => $contacts_arr]));
    return $resp;
  }

}