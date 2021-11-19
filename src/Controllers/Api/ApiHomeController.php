<?php 

namespace Base\Controllers\Api;

use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;

class ApiHomeController {

  public function show(ServerRequestInterface $req): ResponseInterface {
    $req->pipedVar .= " chained";
    $resp = new Response\JsonResponse([
      'Json-content' => "Edit Browser Address bar, to return to Html pages.",
      'Named-Url-Arg' => $req->pipedVar
    ], 200, [], JSON_PRETTY_PRINT);
    return $resp;
  }
  
}