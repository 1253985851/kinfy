<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/26
 * Time: 14:19
 */
namespace App\Controller;
use Kinfy\DB\DB;

class ArticleController extends BaseController
{
    public function index()
    {
       $db = new DB();
       $data = $db->table('article')
           ->L()
             ->where('cate_id','=',10)
             ->whereIsNull('name')
             ->orWhere('sex','=','女')
           ->R()
           ->where('id','>',99)
           //->where('cate_id', '=',1)
           //->where('user_id', '=',5)
           //->limit(3)
           //->get();
          ->first();

$data = $db->table('article')
     ->join('users','article.user_id=users.id')
    ->select('article.id as aid','article.title','users.id as userid','users.username')
    ->take(2)
    ->get();

       print_r($data);

    }


}