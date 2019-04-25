<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/16
 * Time: 15:22
 */
class User
{
    private $where ='';
    private $take = 0;
    public function where($w){
        $this->where .=' and '.$w;
        return $this;
    }

    public function take($n){
        $this->take =$n;
        return $this;
    }

    public function find(){
        echo'查询条件:'.$this->where.'<br>';
        echo'查询数量:'.$this->take.'<br>';
       //sreturn $this;
    }
}
$user = new User();

$r = $user ->where('id=8')
      ->where('name=kill')
      ->take(10)
      ->find();
