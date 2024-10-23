
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL); 

session_start();

$user = null;
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

// -> 
$resultado = 0;
$url = 'create.php?op=insertpokemont&result=' . $resultado;

if(isset($_POST['nombre']) && isset($_POST['peso']) && isset($_POST['altura']) && isset($_POST['tipo']  ) && isset($_POST['numero_evoluciones'])) { 
    $nombre = $_POST['nombre'];
    $peso = $_POST['peso'];
    $altura = $_POST['altura'];
    $tipo = $_POST['tipo'];
    $numero_evoluciones = $_POST['numero_evoluciones'];
    $ok = true;
    $nombre = trim($nombre);

    if(strlen($nombre) < 2 || strlen($nombre) > 100) {
        $ok = false;
    }

    if(!(is_numeric($peso) && $peso > 0 && $peso <= 1000.00)) {
        $ok = false;
    }

    if(!(is_numeric($altura) && $altura > 0 && $altura <= 100.00)) {
        $ok = false;
    }

    $tipos_validos = ['Fuego', 'Agua', 'Planta', 'Eléctrico'];
    if(!in_array($tipo, $tipos_validos)) {
        $ok = false;
    }

    if(!(is_numeric($numero_evoluciones) && intval($numero_evoluciones) >= 0)) {
        $ok = false;
    }
    
    

    if($ok) {
        $sql = 'INSERT INTO pokemon (nombre, peso, altura, tipo, numero_evoluciones) 
                VALUES (:nombre, :peso, :altura, :tipo, :numero_evoluciones)';
        
        $sentence = $connection->prepare($sql);
    
        $parameters = [
            'nombre' => $nombre,
            'peso' => $peso,
            'altura' => $altura,
            'tipo' => $tipo,
            'numero_evoluciones' => $numero_evoluciones
        ];
    
        foreach($parameters as $nombreParametro => $valorParametro) {
            $sentence->bindValue($nombreParametro, $valorParametro);
        }
    
        try {           
            $sentence->execute();
                    
            $resultado = $connection->lastInsertId();
    
            $url = 'index.php?op=insertpokemon&result=' . $resultado;
        } catch(PDOException $e) {
        

             $_SESSION['error']['db'] = 'Error: ' . $e->getMessage();
 
             header('Location: create.php?op=insertpokemon&error=db');
             exit;
        }
    }
    
    if($resultado == 0) {
        $_SESSION['old']['nombre'] = $nombre;
        $_SESSION['old']['peso'] = $peso;
        $_SESSION['old']['altura'] = $altura;
        $_SESSION['old']['tipo'] = $tipo;
        $_SESSION['old']['numero_evoluciones'] = $numero_evoluciones;
    }
    
}


    header('Location: ' . $url);
    exit;
