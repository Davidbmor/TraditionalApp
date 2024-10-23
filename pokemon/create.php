<?php
// control de ssión
session_start();
if(!isset($_SESSION['user'])) {
    header('.');
    exit;
}

//Recupera los datos de la sesion anterior en caso de que haya salido algo mal

$nombre = isset($_SESSION['old']['nombre']) ? $_SESSION['old']['nombre'] : '';
$peso = isset($_SESSION['old']['peso']) ? $_SESSION['old']['peso'] : '';
$altura = isset($_SESSION['old']['altura']) ? $_SESSION['old']['altura'] : '';
$tipo = isset($_SESSION['old']['tipo']) ? $_SESSION['old']['tipo'] : '';
$numero_evoluciones = isset($_SESSION['old']['numero_evoluciones']) ? $_SESSION['old']['numero_evoluciones'] : '';

unset($_SESSION['old']);




?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>dwes</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="..">dwes</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="..">home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="../product">product</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="./">pokemon</a>
                    </li>
                </ul>
            </div>
        </nav>
        <main role="main">
            <div class="jumbotron">
                <div class="container">
                    <h4 class="display-4">Pokemon</h4>
                </div>
            </div>
            <div class="container">
                <?php
                if(isset($_GET['op'])) {
                       ?>
                    <div class="alert alert-danger" role="alert">
                        result: <?= $_GET['op'] ?>
                    </div>
                    <?php

                }
                ?>
                <div>
                    <form action="store.php" method="post">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input value="<?= $nombre ?>" required type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
                        </div>
                        <div class="form-group">
                            <label for="peso">Peso</label>
                            <input value="<?= $peso ?>" required type="number" step="0.001" class="form-control" id="peso" name="peso" placeholder="Peso">
                        </div>
                        <div class="form-group">
                            <label for="altura">Altura </label>
                            <input value="<?= $altura ?>" required type="text" class="form-control" id="altura" name="altura" placeholder="Altura">
                        </div>
                        <div class="form-group">
                            <label for="tipo">Tipo</label>
                                <select required class="form-control" id="tipo" name="tipo" placeholder="Tipo">
                                    <option value="Fuego" <?= $tipo === 'Fuego' ? 'selected' : '' ?>>Fuego</option>
                                    <option value="Agua" <?= $tipo === 'Agua' ? 'selected' : '' ?>>Agua</option>
                                    <option value="Planta" <?= $tipo === 'Planta' ? 'selected' : '' ?>>Planta</option>
                                    <option value="Eléctrico" <?= $tipo === 'Eléctrico' ? 'selected' : '' ?>>Eléctrico</option>
                                </select>                        
                        </div>
                        <div class="form-group">
                            <label for="numero_evoluciones">Evoluciones</label>
                            <input value="<?= $numero_evoluciones ?>" required type="number" class="form-control" id="numero_evoluciones" name="numero_evoluciones" placeholder="Evoluciones ">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">add</button>
                    </form>
                </div>
                <hr>
            </div>
        </main>
        <footer class="container">
            <p>&copy; IZV 2024</p>
        </footer>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>