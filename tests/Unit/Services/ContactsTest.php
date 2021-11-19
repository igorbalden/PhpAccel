<?php 

namespace Tests\Unit\Services;
use Base\Services\Contacts\Contacts;
use PHPUnit\Framework\TestCase;

class ContactsTest extends TestCase {
  public $db;

  public function setup(): void {
    global $db;
    $this->db = $db;
  }

  /** @test */
  public function get_contacts_from_testdb() {
    $contacts_orig = new Contacts();
    $contacts_arr = $contacts_orig->get_contacts();

    $this->assertStringContainsString('test@demo.com', 
      $contacts_arr[0]['email']);
    $this->assertStringContainsString('test@domain.com', 
      $contacts_arr[1]['email']);
  }

}