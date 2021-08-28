<?php defined('SYSTEMPATH') || exit('No direct script access allowed'); ?>

CRITICAL - 2021-05-18 21:45:14 --> Undefined index: password
#0 /var/www/html/b2c/app/Controllers/Ajax.php(308): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/var/www/html/b...', 308, Array)
#1 /var/www/html/b2c/system/CodeIgniter.php(844): App\Controllers\Ajax->autoLogin()
#2 /var/www/html/b2c/system/CodeIgniter.php(335): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Ajax))
#3 /var/www/html/b2c/system/CodeIgniter.php(245): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /var/www/html/b2c/index.php(46): CodeIgniter\CodeIgniter->run()
#5 {main}
