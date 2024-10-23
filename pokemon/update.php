<?php

ini_set('display_errors', 1);
error_reporting(E_ALL); 

session_start();

if(isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}

try {
    $connection = new PDO(
      'mysql:host=localhost;dbname=pokemon_database',
      'pokemon_user',
      'pokemon_password',
      array(
        PDO::ATTR_PERSISTENT => true,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8')
    );
} catch(PDOException $e) {
    echo 'no connection';
    exit;
}


if(isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    //echo 'no id';
    header('Location: ..');
    exit;
}
if(isset($_POST['nombre'])) {
    $nombre = trim($_POST['nombre']);
} else {
    header('Location: .');
    //echo 'no name';
    exit;
}
if(isset($_POST['peso'])) {
    $peso = $_POST['peso'];
} else {
    header('Location: .');
    //echo 'no price';
    exit;
}
if(isset($_POST['altura'])) {
    $altura = $_POST['altura'];
} else {
    header('Location: .');
    //echo 'no price';
    exit;
}
if(isset($_POST['tipo'])) {
    $tipo = $_POST['tipo'];
} else {
    header('Location: .');
    //echo 'no price';
    exit;
}
if(isset($_POST['numero_evoluciones'])) {
    $numero_evoluciones = $_POST['numero_evoluciones'];
} else {
    header('Location: .');
    //echo 'no price';
    exit;
}
//debería meter la misma validación que antes en store.php
$sql = 'UPDATE pokemon 
        SET nombre = :nombre, 
            peso = :peso, 
            altura = :altura, 
            tipo = :tipo, 
            numero_evoluciones = :numero_evoluciones.
        WHERE id = :id';

$sentence = $connection->prepare($sql);
    
$parameters = [
    'nombre' => $nombre,
    'peso' => $peso,
    'altura' => $altura,
    'tipo' => $tipo,
    'numero_evoluciones' => $numero_evoluciones,
    'id' => $id  
];

foreach($parameters as $nombreParametro => $valorParametro) {
    $sentence->bindValue($nombreParametro, $valorParametro);
}

try {           
    $sentence->execute();
            
    $resultado = $sentence->rowCount();

    $url = '.?op=editpokemon&result=' . $resultado;
} catch(PDOException $e) {


     $_SESSION['error']['db'] = 'Error: ' . $e->getMessage();

     header('Location: edit.php?op=editpokemon&error=db');
     exit;
}
header('Location: ' . $url);

