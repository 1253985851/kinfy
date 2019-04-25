<?php
/**
 * 查询数据
 */
//1.连接数据库
try {
    $pdo = new PDO("mysql:host=localhost;dbname=test1", "root", "root");
} catch (PDOException $e) {
    die("fail to connect mysql" . $e->getMessage());
}
//print_r($pdo);
//2.执行query(查询)返回一个预处理对象,使用快捷方式
$sql = "SELECT * FROM users";
foreach ($pdo->query($sql) as $val) {
    echo $val['id'] . "------" . $val['name'] . "------" . $val['age'] . "<br/>";
}
/**
 * 添加数据
 */
$sql = "INSERT INTO users VALUES(null,'Susan','29')";

/**
 * 更新数据
 */
$sql = "UPDATE users set name='Kill' WHERE id=1";

/**
 * 删除数据
 */
$sql = "DELETE FROM users WHERE id=8";

$res = $pdo->exec($sql);
if ($res) {
    echo "success";
}