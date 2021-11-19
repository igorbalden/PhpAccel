<?php 

namespace Base\Services\Users;

class Auth {

  public $db;

  public function __construct() {
    global $container;
    $this->db = $container->get('dbdefault');
  }

  public function login($inp_arr): array {
    $resp_arr = array();
    $sql = "SELECT u.id, u.password, g.descr 
      FROM users u JOIN users_groups g ON u.user_group_id = g.id
      WHERE u.email LIKE :email";
    $stmt = $this->db->executeQuery($sql, ["email" => $inp_arr['email']]);
    $found_arr = $stmt->fetchAllAssociative();
    if (count($found_arr) !== 1 || 
        !password_verify($inp_arr['password'], $found_arr[0]['password'])
    ) {
      $resp_arr['error'] = "Not Authenticated.";
      return $resp_arr;
    }
    $resp_arr['id'] = $found_arr[0]['id'];
    $resp_arr['group'] = $found_arr[0]['descr'];
    return $resp_arr;
  }

}