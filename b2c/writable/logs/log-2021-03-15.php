<?php defined('SYSTEMPATH') || exit('No direct script access allowed'); ?>

CRITICAL - 2021-03-15 16:03:42 --> Call to undefined function App\Controllers\SendMail()
#0 /var/www/html/b2c/system/CodeIgniter.php(844): App\Controllers\Ajax->forget_password()
#1 /var/www/html/b2c/system/CodeIgniter.php(335): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Ajax))
#2 /var/www/html/b2c/system/CodeIgniter.php(245): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#3 /var/www/html/b2c/index.php(46): CodeIgniter\CodeIgniter->run()
#4 {main}
