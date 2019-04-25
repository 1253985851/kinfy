<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/26
 * Time: 14:23
 */
require_once __DIR__.'./../vendor/autoload.php';

if(file_exists(_DIR_.'./../app/common/common_function.php')){
    require_once __DIR__.'./../app/common/common_function.php';
}
require_once __DIR__.'./../Kinfy/common/common_function.php';
use Kinfy\Http\Router;
use Kinfy\Http\Controller;

require_once __DIR__.'./../app/router/web.php';

//路由未匹配中执行的回调函数
Router::$onMissMatch = function(){
    die('404');
};

//路由匹配中执行的回调函数
Router::$onMatch = function($callback,$params){
    Controller::run($callback,$params);
};


Router::dispatch();
//$ctrl = 'App\Controller\\'.$_GET['c'].'Controller';
//$method = $_GET['m'];
//
//$art = new $ctrl();
//$art->{$method}();