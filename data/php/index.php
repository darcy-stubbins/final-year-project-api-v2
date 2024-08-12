<?php

require_once (__DIR__ . '/autoload.php');
use Classes\Router;

/** 
 * This is where you say:
 * "www.mycoolsite.com/my/end/point needs to redirect to abc.php"
 * "www.mycoolsite.com/my/other/end/point needs to redirect to xyz.php"
 * etc...
 * 
 * For now, it just returns php info which tells you everything about your PHP installation like enabled packages, version info, maximum upload size, etc
 */

header('Content-Type: application/json');
$router = new Router($_SERVER['REQUEST_URI'], $_POST ?? []);
//url layout: /{objectType}/{function}

?>