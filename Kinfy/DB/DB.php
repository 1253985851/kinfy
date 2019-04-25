<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/18
 * Time: 9:47
 */

namespace Kinfy\DB;

use PDO;

class DB
{

    public $pdo = null;
    public $fields = [];
    public $where = [];
    public $table = '';
    public $limit = [];
    public $sql =[];
    public $join ='';
    public function __construct($conf = null)
    {
        if (!$conf) {
            $conf = [
                'dbms' => 'mysql',     //数据库类型
                'host' => '127.0.0.1', //数据库主机名
                'name' => 'kinfy',      //使用的数据库
                'user' => 'root',      //数据库连接用户名
                'pass' => 'root',      //对应的密码
            ];
        }
        $dsn = "{$conf['dbms']}:host={$conf['host']};dbname={$conf['name']}";
        $this->pdo = new PDO($dsn, $conf['user'], $conf['pass']);
        //设置全局属性，默认读取的数据以关联数组的形式返回
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    }

    public function table($name)
    {
        $this->table = $name;
        return $this;
    }

    public function select(...$field)
    {
        $this->table = $field;
        return $this;
    }

    public function limit($offset, $num)
    {
        $this->limit = [$offset, $num];
        return $this;
    }

    public function take($num)
    {
        return $this->limit(0, $num);
    }

    public function first()
    {
        $r = $this->take(1)->get();
        if (isset($r[0])) {
            return $r[0];
        } else {
            return false;
        }
    }
    public function where($field, $op, $val)
    {
        return $this->andWhere($field,$op,$val);

    }
    //$this->where[ [$field, $op, $val], [$field, $op, $val], [$field, $op, $val] ]


    public function andWhere($field,$op,$val = null)
    {
        return $this->_where($field,$op,$val,'AND');
    }

    public function orWhere($field,$op,$val = null)
   {
       return $this->_where($field,$op,$val,'OR');
   }

   public function whereNull($field)
   {
       return $this->andWhereNull($field);
   }

   public function andWhereNull($field){
        return $this->_where($field,'IS','NULL','AND');
   }

    public function orWhereNull($field){
        return $this->_where($field,'IS','NULL','OR');
    }

    public function WhereNotNull($field){
        return $this->andWhereNotNull($field);
    }

    public function andWhereNotNull($field){
        return $this->_where($field,'IS NOT','NULL','AND');
    }

    public function orWhereNotNull($field){
        return $this->_where($field,'IS NOT','NULL','OR');
    }

    public function _where($field, $op, $val,$type)
    {
        if($val === null){
            $val = $op;
            $op = '=';
        }
        $this->where[] = [
            'condition' => [$field,$op,$val],
            'type' => $type
        ];
        return $this;

    }
   public function L(){
        $this->where[] = '(';
   }

    public function R(){
        $this->where[] = ')';
    }

    private function genWhere()
    {
        //1.生成带?的条件语句
        $where = '';
        //2.生成?对应的值的数组
        $values = [];
        $sep = '';
        //$this->where[ ['cate_id', '=', 10], ['user_id','=',5] ]
        foreach ($this->where as $c) {
            if($c == '(' || $c ==')'){
                $where .= $c;
            }else if (isset($c['condition']) && isset($c['type'])){
                list($field, $op, $val) = $c['condition'];
                $where .= " {$sep} `{$field}` {$op} ?";
                //默认条件关系是AND
                $sep = "{$c['type']}";
                $values[] = $val;
            }
        }
        if ($where) {
            $where = ' WHERE ' . $where;
        }
        return [$where, $values];
    }



    private function genSql($sql=[])
    {
        if($this->sql){
            return $this->sql;
        }

        list($WHERE,$VAL) = $this->genWhere();
        $LIMIT ='';
        if ($this->limit) {
            $LIMIT = " LIMIT {$this->limit[0]},{$this->limit[1]} ";
        }
        $FIELDS = '*';
            if (!empty($this->fields)) {
            $FIELDS = '`' . implode('`,`', $this->fields) . '`';
        }
        $JOIN = $this->join;
        $this->sql['sql'] = "SELECT {$FIELDS} FROM {$this->table} {$JOIN}{$WHERE} {$LIMIT}";
        $this->sql['value'] = $VAL;

        return $this->sdl;
    }

    public function join ($table,$condition)
    {
        $this->join =" JOIN {$table} ON {$condition}";
        return $this;
    }

    public function get()
    {
        $this->genSql();
//        //2.准备prepare语句和参数对应的数组值
        $pdosmt = $this->pdo->prepare($this->sql['sql']);
        $r = $pdosmt->execute($this->sql['value']);
        if(!$r) {
           print_r($pdosmt->errorInfo());
        }
        return $pdosmt->fetchAll();
    }


}

