<?php 

namespace Base\Services\Users;

class Register {

  public $db;

  public function __construct() {
    global $container;
    $this->db = $container->get('dbdefault');
  }

  public function save_user($inp_arr): array {
    $resp_arr = array();
    $sql = "SELECT COUNT(id) as uc FROM users WHERE email LIKE :email";
    $stmt = 
      $this->db->executeQuery($sql, 
        ["email" => $inp_arr['email']]
      );
    $count_arr = $stmt->fetchAllAssociative();
    if ($count_arr[0]['uc'] > 0) {
      $resp_arr['error'] = "User email already exists.";
      return $resp_arr;
    }
    // Store user
    $sql = "INSERT INTO users (`email`, `password`, `active`, `user_group_id`,  
              `created`) 
            VALUES (:email, :password, :active, :user_group_id, :created)";
    $stmt = 
      $this->db->executeQuery($sql, [
          'email' => $inp_arr['email'],
          'password' => password_hash($inp_arr['password'], PASSWORD_DEFAULT),
          'active' => 1,
          'user_group_id' => 2,
          'created' => date('Y-m-d H:i:s')
        ]
      );
    $user_id = $this->db->lastInsertId();
    $resp_arr['msg'] = "New user id is: ". $user_id;
    return $resp_arr;
  }

}