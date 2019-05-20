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
    $id = $_SESSION["id"];
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
    <title>Ajustes</title>
</head>

<body>

    <!--Navbar -->
    <nav class="mb-1 navbar navbar-expand-lg navbar-dark info-color">
        <h3 class="navbar-brand">Ajustes de <?php echo $usuario; ?></h3>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user icon-user"></i> Perfil </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">
                        <a class="dropdown-item icon-list-bullet" href="./main.php"> Volver a Notas</a>
                        <a class="dropdown-item icon-user-times " id="logout" href="./main.php?logout"> Cerrar Sesión</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div id="navs">
        <!--tarjetas -->
        <div class="card text-white bg-warning mb-3 opciones" style="max-width: 18rem;">
            <div class="card-header">Cambiar Contraseña</div>
            <div class="card-body">
                <h5 class="card-title">Sustituirás tu contraseña actual</h5>
                <p class="card-text">Utiliza siempre contraseñas fuertes incluyendo letras, números y símbolos.</p>
                <button href='' class='completar btn btn-info' id='btnCambiaPasswd'> Cambiar Contraseña</button>
            </div>
        </div>

        <div class="card text-white bg-danger mb-3 opciones" style="max-width: 18rem;">
            <div class="card-header">Borrar Cuenta</div>
            <div class="card-body">
                <h5 class="card-title">¡ATENCIÓN!</h5>
                <p class="card-text">Borrarás tu cuenta y todas tus notas, por lo tanto no podrás recuperarlas, hazlo solo si estás seguro.</p>
                ¿Estás seguro? &nbsp;<input type="checkbox" class="" name="" id="chkBorrar">
                <button type='button' class='borrar btn btn-outline-warning icon-trash-1' href='' id='btnBorrarCuenta' disabled>Borrar Cuenta</button>
            </div>
        </div>

    </div>
    <script>
        $(document).ready(function() {

            // Confirmación borrar cuenta
            $("#chkBorrar").click(function() {
                if ($("#chkBorrar").prop("checked")) {
                    $("#btnBorrarCuenta").removeAttr("disabled");
                } else if (!$("#chkBorrar").prop("checked")) {
                    $("#btnBorrarCuenta").attr("disabled", "true");
                }
            })

            // Borrar cuenta
            $("#btnBorrarCuenta").click(function() {
                window.location.assign("./ajustes.php?borrar")
            })

            // Redirección Cambiar password
            $("#btnCambiaPasswd").click(function() {
                window.location.assign("./cambiaPassword.php");
            })

        })
    </script>

    <!-- Borrar la cuenta y sus notas -->
    <?php
    if (isset($_GET["borrar"])) {
        $q = "DELETE FROM `chores` WHERE `id_user` = '" . $id . "'";
        $r = mysqli_query($ms, $q);
        if (!$r) {
            echo "<br>ERROR EN LA INSERCION";
        } else {
            $q2 = "DELETE FROM `users` WHERE `id` = '" . $id . "'";
            $r2 = mysqli_query($ms, $q2);
            ?><script>window.location.assign("./ajustes.php?logout")</script>
            <?php
        }
    }

    // Idea de meter imágenes a los perfiles o bien por URL o por archivo ¿?, mejor por url
    ?>
</body>

</html>