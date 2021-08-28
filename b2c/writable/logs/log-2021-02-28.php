<?php defined('SYSTEMPATH') || exit('No direct script access allowed'); ?>

CRITICAL - 2021-02-28 02:32:31 --> Invalid HTTP Protocol Version. Must be one of: {0}
#0 /var/www/html/b2c/system/HTTP/Message.php(373): CodeIgniter\HTTP\Exceptions\HTTPException::forInvalidHTTPProtocol('1.0, 1.1, 2')
#1 /var/www/html/b2c/system/CodeIgniter.php(498): CodeIgniter\HTTP\Message->setProtocolVersion('0.9')
#2 /var/www/html/b2c/system/CodeIgniter.php(219): CodeIgniter\CodeIgniter->getRequestObject()
#3 /var/www/html/b2c/index.php(46): CodeIgniter\CodeIgniter->run()
#4 {main}
