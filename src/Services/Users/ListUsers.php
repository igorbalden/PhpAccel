<?php 

namespace Base\Services\Users;

class ListUsers {

  public $db;

  public function __construct() {
    global $container;
    $this->db = $container->get('dbdefault');
  }

  public function list_all(): array {
    $sql = "SELECT u.id, u.email, u.active, g.descr 
      FROM users u JOIN users_groups g ON u.user_group_id = g.id";
    $stmt = $this->db->executeQuery($sql);
    $found_arr = $stmt->fetchAllAssociative();
    return $found_arr;
  }

}