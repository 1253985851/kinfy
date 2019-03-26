<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/26
 * Time: 14:59
 */
namespace Kinfy\Http;
class Router
{

    public static $routes=[];
    //REQUEST_METHOD
    //REDIRECT_URL

    public static function GET($pattern,$callback)
    {
        self::$routes['GET'][$pattern] = $callback;
    }
    public static function POST($pattern,$callback)
    {
        self::$routes['POST'][$pattern] = $callback;
    }
    public static function dispatch()
    {
        $request_type = strtoupper($_SERVER['REQUEST_METHOD']);
        $pattern = strtoupper($_SERVER['REDIRECT_URL']);

        if(isset(self::$routes[$request_type][$pattern])){
            $callback = self::$routes[$request_type][$pattern];
            if(is_callable($callback)){
                call_user_func($callback);
            }else{
                list($class,$method) = explode('@',$callback);
                $class ='App\\Controller\\'.$class;
                $obj = new $class();
                $obj->{$method}();

            }
        }else{
            header("HTTP/1.1 404 NOT Found");
            exit;
        }
    }

}