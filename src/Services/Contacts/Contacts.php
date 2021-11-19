<?php 

namespace Base\Services\Contacts;

class Contacts {

  public $db;

  public function __construct() {
    global $container;
    $this->db = $container->get('dbdefault');
  }

  public function get_contacts(): array {
    $minid = 0;
    $sql = "SELECT * FROM contactus WHERE id > :minid";
    $stmt = 
      $this->db->executeQuery($sql, 
        ["minid" => $minid]
      );
    $contacts_arr = $stmt->fetchAllAssociative();
    return $contacts_arr;
  }

}