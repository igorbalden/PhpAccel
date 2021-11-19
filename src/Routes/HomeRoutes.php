<?php 
if (!isset($container)) throw(new ErrorException('Routes undefined.'));

use Base\Controllers\HomeController;
use Base\Controllers\ContactsController;

$router->map('GET', 'contacts', 
  [ContactsController::class, 'contacts']
);
  
$router->map('GET', '/', 
  [HomeController::class, 'home']
);
