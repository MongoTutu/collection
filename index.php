<?php

if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

define('APP_DEBUG',true);
define('APP_PATH','./Application/');
$server_ip = require dirname(dirname(__FILE__)).'/ip.php';
define('MONGO_SERVER', $server_ip['db_server']);

require './ThinkPHP/ThinkPHP.php';
