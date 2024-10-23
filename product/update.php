<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
if(!isset($_SESSION['user'])) {
    header('Location:.');
    exit;
}
try {
    $connection = new \PDO(
      'mysql:host=localhost;dbname=productdatabase',
      'productuser',
      'productpassword',
      array(
        PDO::ATTR_PERSISTENT => true,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8')
    );
} catch(PDOException $e) {
    //echo 'no connection';
    header('Location: ..');
    exit;
}
if(isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    //echo 'no id';
    header('Location: ..');
    exit;
}
if(isset($_POST['name'])) {
    $name = trim($_POST['name']);
} else {
    header('Location: .');
    //echo 'no name';
    exit;
}
if(isset($_POST['price'])) {
    $price = $_POST['price'];
} else {
    header('Location: .');
    //echo 'no price';
    exit;
}
//debería meter la misma validación que antes en store.php
$sql = 'update product set name = :name, price = :price where id = :id';
$sentence = $connection->prepare($sql);
$parameters = ['name' => $name, 'price' => $price, 'id' => $id];
foreach($parameters as $nombreParametro => $valorParametro) {
    $sentence->bindValue($nombreParametro, $valorParametro);
}
try {
    $sentence->execute();
    $resultado = $sentence->rowCount();
    $url = '.?op=editproduct&result=' . $resultado;
} catch(PDOException $e) {
    $resultado = 0;
    $_SESSION['old']['name'] = $name;
    $_SESSION['old']['price'] = $price;
}
header('Location: ' . $url);