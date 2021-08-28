<?php defined('SYSTEMPATH') || exit('No direct script access allowed'); ?>

CRITICAL - 2021-01-19 12:32:21 --> session_start(): Failed to decode session object. Session has been destroyed
#0 [internal function]: CodeIgniter\Debug\Exceptions->errorHandler(2, 'session_start()...', '/var/www/html/b...', 1001, Array)
#1 /var/www/html/b2c/system/Session/Session.php(1001): session_start()
#2 /var/www/html/b2c/system/Session/Session.php(237): CodeIgniter\Session\Session->startSession()
#3 /var/www/html/b2c/system/Config/Services.php(773): CodeIgniter\Session\Session->start()
#4 /var/www/html/b2c/system/Config/BaseService.php(119): CodeIgniter\Config\Services::session(Object(Config\App), false)
#5 /var/www/html/b2c/system/Config/Services.php(754): CodeIgniter\Config\BaseService::getSharedInstance('session', NULL)
#6 /var/www/html/b2c/app/Controllers/BaseController.php(39): CodeIgniter\Config\Services::session()
#7 /var/www/html/b2c/app/Controllers/Ajax.php(17): App\Controllers\BaseController->__construct()
#8 /var/www/html/b2c/system/CodeIgniter.php(819): App\Controllers\Ajax->__construct()
#9 /var/www/html/b2c/system/CodeIgniter.php(330): CodeIgniter\CodeIgniter->createController()
#10 /var/www/html/b2c/system/CodeIgniter.php(245): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#11 /var/www/html/b2c/index.php(46): CodeIgniter\CodeIgniter->run()
#12 {main}
CRITICAL - 2021-01-19 12:32:21 --> Invalid argument supplied for foreach()
#0 /var/www/html/b2c/app/Controllers/Ajax.php(268): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/var/www/html/b...', 268, Array)
#1 /var/www/html/b2c/system/CodeIgniter.php(844): App\Controllers\Ajax->purchaseGame('75')
#2 /var/www/html/b2c/system/CodeIgniter.php(335): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Ajax))
#3 /var/www/html/b2c/system/CodeIgniter.php(245): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /var/www/html/b2c/index.php(46): CodeIgniter\CodeIgniter->run()
#5 {main}
CRITICAL - 2021-01-19 12:32:21 --> Invalid argument supplied for foreach()
#0 /var/www/html/b2c/app/Controllers/Ajax.php(268): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/var/www/html/b...', 268, Array)
#1 /var/www/html/b2c/system/CodeIgniter.php(844): App\Controllers\Ajax->purchaseGame('64')
#2 /var/www/html/b2c/system/CodeIgniter.php(335): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Ajax))
#3 /var/www/html/b2c/system/CodeIgniter.php(245): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /var/www/html/b2c/index.php(46): CodeIgniter\CodeIgniter->run()
#5 {main}
