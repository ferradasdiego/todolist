<?php
session_start();
require './db.php';

//si no estás logueado te redirige hacia el index
if (!isset($_SESSION["user"]) && !isset($_SESSION["id"])) {
    header("location: ./index.php");
}
//Saludo
if (isset($_SESSION["user"]) && isset($_SESSION["id"])) {
    $usuario = $_SESSION["user"];
}

//Cerrar Sesión
if (isset($_GET["logout"])) {
    session_start();
    session_destroy();
    unset($_SESSION['user']);
    unset($_SESSION['id']);
    header("location:./index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="./fontello/css/todolist.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <title>Cambiar la Contraseña</title>
</head>

<body>
    <!--Navbar -->
    <nav class="mb-1 navbar navbar-expand-lg navbar-dark info-color">
        <h3 class="navbar-brand">Cambiar la Contraseña de <?php echo $usuario; ?></h3>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user icon-user"></i> Perfil </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">
                        <a class="dropdown-item icon-cog" href="./ajustes.php"> Volver a Ajustes</a>
                        <a class="dropdown-item icon-list-bullet" href="./main.php"> Volver a Notas</a>
                        <a class="dropdown-item icon-user-times " id="logout" href="./main.php?logout"> Cerrar Sesión</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>



    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <h4 class="card-title text-center">Cambio de Contraseña</h4>
                        <form class="form-signin" action="./cambiaPassword.php" method="post">

                            <!-- Me quedo aquí, tengo que hacer las comprobaciones de que la oldPass sea correcta y que las 2 nuevas coinciden.-->
                            <!-- Si todo esto es correcto me conecto a la BDD y actualizo la pass con la newPass codificada -->
                            <!-- Creo que lo tengo hecho en el DIWBOOK -->

                            <div class="form-label-group">
                                <input type="password" id="inputPassOld" name="passOld" class="form-control" placeholder="Contraseña Actual" required autofocus>
                                <label for="inputPassOld">Contraseña Actual</label>
                            </div>

                            <div class="form-label-group">
                                <input type="password" id="inputPasswdNew1" name="passwdNew1" class="form-control" placeholder="Nueva Contraseña" required>
                                <label for="inputPasswdNew1">Nueva Contraseña</label>
                            </div>

                            <div class="form-label-group">
                                <input type="password" id="inputPasswdNew2" name="passwdNew2" class="form-control" placeholder="Nueva Contraseña" required>
                                <label for="inputPasswdNew2">Repite tu nueva contraseña</label>
                            </div>

                            <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Cambiar la contraseña</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php

    if (isset($_POST["passOld"]) && isset($_POST["passwdNew1"]) && isset($_POST["passwdNew2"])) {

        $oldPass = $_POST["passOld"];
        $newPass1 = $_POST["passwdNew1"];
        $newPass2 = $_POST["passwdNew2"];

        if ($oldPass != "" && $newPass1 != "" && $newPass2 != "") {
            if ($newPass1 != $newPass2) {
                echo "<script>alert('Ups....Has escrito mal las nuevas contraseñas no coinciden')</script>";
            } else {
                if ($newPass1 == $oldPass) { 
                    echo "<script>alert('La vieja contraseña y la nueva no deben coincidir')</script>";
                } else {
                    $q = "SELECT * FROM `users` WHERE `user` = '" . $usuario . "'";
                    $r = mysqli_query($ms, $q);
                    if (mysqli_num_rows($r) < 1) {
                        echo '<script>alert("HOLA")</script>';
                    } else {
                        $devolucion = mysqli_fetch_assoc($r); //lo transforma en un array

                        if (hash_equals($devolucion["password"], crypt($oldPass, $devolucion["password"]))) { //si el hash de la vieja es igual al que metes en oldPass

                            $hashed_password = crypt($newPass1, "aB1(.");    //la newPass hasheada

                            $q2 = "UPDATE `users` SET `password`= '" . $hashed_password . "' WHERE `user` = '" . $usuario . "'";
                            $r2 = mysqli_query($ms, $q2);

                            
                            echo "Contraseña cambiada con éxito";
                            // header("location: ./cambiaContraseña.php");
                        } else {
                            echo "<script>alert('Ups....Has escrito mal la vieja contraseña')</script>";
                        }
                    }
                }
            }
        }
    }
    ?>
</body>

</html>