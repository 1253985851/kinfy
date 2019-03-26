<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/26
 * Time: 14:23
 */
require_once __DIR__.'./../vendor/autoload.php';
require_once __DIR__.'./../app/router/web.php';
\Kinfy\Http\Router::dispatch();
//$ctrl = 'App\Controller\\'.$_GET['c'].'Controller';
//$method = $_GET['m'];
//
//$art = new $ctrl();
//$art->{$method}();