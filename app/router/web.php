<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/26
 * Time: 14:57
 */

use Kinfy\Http\Router;


//Router::rule('id','\d+');
//
//Router::get('/', function () {
//    echo 'index';
//});
//
//Router::get('foo', function () {
//    echo 'Hello World';
//});
//
////Router::get('user/{id}', function ($id) {
////    echo $id;
////});
//
//Router::any('user/{id}/{name?}', function ($id,$name='') {
//    echo $id;
//    echo $name;
//},['id'=>'\d{1,3}']);
//
//Router::any('art/{id}', function ($id) {
//    echo $id;
//});

Router::GET('user/login','UserController@login');

Router::GET('user/del/{id}','UserController@del');

Router::GET('/test',function(){
    require_once '../test/User.php';

});

Router::GET('/article','ArticleController@index');



