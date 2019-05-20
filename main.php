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

//Borrar Tarea
if (isset($_GET["borrar"])) {
    $q = "DELETE FROM `chores` WHERE `id_tarea` = '" . $_GET["borrar"] . "'";
    $r = mysqli_query($ms, $q);
    if (!$r) {
        echo "<br>ERROR EN LA INSERCION";
    } else {
        header("location: ./main.php");
    }
}

//Completar Tarea
if (isset($_GET["completar"])) {
    $q = "UPDATE `chores` SET clase= 'completada' WHERE `id_tarea` = '" . $_GET["completar"] . "'";
    $r = mysqli_query($ms, $q);
    if (!$r) {
        echo "<br>ERROR EN LA INSERCION";
    } else {
        header("location: ./main.php");
    }
}

//Descompletar Tarea
if (isset($_GET["descompletar"])) {
    $q = "UPDATE `chores` SET clase= ' ' WHERE `id_tarea` = '" . $_GET["descompletar"] . "'";
    $r = mysqli_query($ms, $q);
    if (!$r) {
        echo "<br>ERROR EN LA INSERCION";
    } else {
        header("location: ./main.php");
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="./fontello/css/todolist.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
  } );
  </script>
    <title>Tareas</title>
</head>
<body>

<!--Navbar -->
<nav class="mb-1 navbar navbar-expand-lg navbar-dark info-color" style="margin-bottom: 0px !important;">
  <h3 class="navbar-brand">Notas de <?php echo $usuario; ?></h3>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
    aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent-4" >
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true"
          aria-expanded="false">
          <i class="fas fa-user icon-user"></i> Perfil </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">
          <a class="dropdown-item icon-cog" href="./ajustes.php"> Ajustes</a>
          <a class="dropdown-item icon-user-times " id="logout" href="./main.php?logout"> Cerrar Sesión</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
<!--/.Navbar -->

    <!-- formulario con el textarea y el submit fuera -->
    <div id="introducir">
        <form action="./main.php" method="post" id="formulario">
            <input type="text" name="titulo" placeholder="Introduce el titulo de tu tarea" style="width:60%; border:1px solid black">
        </form>
        <textarea placeholder="Introduce el cuerpo de tu tarea." rows="4" cols="50" name="cuerpo" id="campo" form="formulario" style="width:60%; padding:0px; border:1px solid black"></textarea>
        <button type="submit" class="btn btn-primary" form="formulario" style='border:1px solid black'>Publicar Tarea</button>
    </div>
    <!-- /formulario -->

    <div id="tareas">

    <?php

        //Cargar las tareas al entrar en la página

        $q = "SELECT * FROM `chores` WHERE `id_user` = '" . $_SESSION["id"] . "'";
        $r = mysqli_query($ms, $q);
        if (!$r) {
            echo "<br>ERROR EN CONSULTA: ";
        } else {
            if (mysqli_num_rows($r) < 1) {
                echo "Aún no hay tareas";
            } else {
                echo "<ul id='sortable' style='list-style:none'>";
                while ($resultado = mysqli_fetch_assoc($r)) { //mientras hay tareas por mostrar

                    //si la tarea no está completada
                    if ($resultado['clase'] != "completada") {
                        // echo "<div class='tarea' id='" . $resultado['id_tarea'] . "'>";
                        // echo "<u class='" . $resultado['clase'] . "'>" . $resultado["titulo"] . "</u>: ";
                        // echo "<br>";
                        // echo "<p class='" . $resultado['clase'] . "'>" . $resultado['cuerpo'] . "</p>";
                        // echo "<button href='./main.php?completar=" . $resultado['id_tarea'] . "' class='completar btn btn-success icon-check' id='" . $resultado['id_tarea'] . "'>Completar</button><button type='button' class='borrar btn btn-danger icon-trash-1' href='./main.php?borrar=" . $resultado['id_tarea'] . "' id='" . $resultado['id_tarea'] . "'>Borrar</button></div><hr>";
                        
                        echo'<li>
                        <div class="card text-white bg-dark mb-3 tarea" id="'. $resultado['id_tarea'] .'" >
                        <div class="card-header '. $resultado['clase'] .'">'. $resultado['titulo'] .'</div>
                        <div class="card-body">
                            <p class="card-text '. $resultado['clase'] .'">'. $resultado['cuerpo'] .'</p>';
                        echo "<button href='./main.php?completar=" . $resultado['id_tarea'] . "' class='completar btn btn-success icon-check' id='" . $resultado['id_tarea'] . "'style='border:1px solid black'>Completar</button><button type='button' class='borrar btn btn-danger icon-trash-1' href='./main.php?borrar=" . $resultado['id_tarea'] . "' id='" . $resultado['id_tarea'] . "'style='border:1px solid black'>Borrar</button></div>";
                        echo '</div></li>';                    
                    
                    
                    
                    //si la tarea está completada
                    } else {
                        // echo "<div class='tarea' id='" . $resultado['id_tarea'] . "'>";
                        // echo "<u class='" . $resultado['clase'] . "'>" . $resultado["titulo"] . "</u>: ";
                        // echo "<br>";
                        // echo "<p class='" . $resultado['clase'] . "'>" . $resultado['cuerpo'] . "</p>";
                        // echo "<button href='./main.php?descompletar=" . $resultado['id_tarea'] . "' class='descompletar btn btn-success icon-back' id='" . $resultado['id_tarea'] . "'>Descompletar</button> <button type='button' class='borrar btn btn-danger icon-trash-1' id='" . $resultado['id_tarea'] . "'>Borrar</button></div><hr>";
                    
                        echo'<li>
                        <div class="card bg-success mb-3 tarea" id="'. $resultado['id_tarea'] .'" >
                        <div class="card-header '. $resultado['clase'] .'">'. $resultado['titulo'] .'</div>
                        <div class="card-body">
                            <p class="card-text '. $resultado['clase'] .'">'. $resultado['cuerpo'] .'</p>';
                        echo "<button href='./main.php?descompletar=" . $resultado['id_tarea'] . "' class='descompletar btn btn-success icon-back' id='" . $resultado['id_tarea'] . "' style='border:1px solid black'>Desompletar</button><button type='button' class='borrar btn btn-danger icon-trash-1' href='./main.php?borrar=" . $resultado['id_tarea'] . "' id='" . $resultado['id_tarea'] . "' style='border:1px solid black'>Borrar</button></div>";
                        echo '</div></li>';                     
                     
                    }
                    
                }
                echo "</ul>";
            }
        }

        //************************************

        //Introducir una nota en la bd
        if (isset($_POST["titulo"]) && isset($_POST["cuerpo"])) {
            if ($_POST["titulo"] != "") {
                $q = "INSERT INTO `chores` (`id_user`,`titulo`,`cuerpo`) VALUES ('" . $_SESSION["id"] . "','" . $_POST["titulo"] . "','" . $_POST["cuerpo"] . "')";
            } else {
                $q = "INSERT INTO `chores` (`id_user`,`titulo`,`cuerpo`) VALUES ('" . $_SESSION["id"] . "','Titulo por defecto','" . $_POST["cuerpo"] . "')";
            }

            $r = mysqli_query($ms, $q);
            if (!$r) {
                echo "<br>ERROR EN LA INSERCION";
            } else {
                ?>
                <!-- Reedirección con JS -->
                <script>
                    window.location.assign("./main.php");
                </script>
                <?php
                // header("location: ./main.php");
            }
        }
        //*****************************

    ?>
        <script>
            $(document).ready(function(){
                //evento borrar
                $(".borrar").click(function(){
                    var id=$(this).attr("id")
                    window.location.assign("./main.php?borrar="+id)
                })

                //evento completar
                $(".completar").click(function(){
                    var id=$(this).attr("id")
                    window.location.assign("./main.php?completar="+id)
                })

                //aqui tengo que hacer el evento descompletar
                $(".descompletar").click(function(){
                    var id=$(this).attr("id")
                    window.location.assign("./main.php?descompletar="+id)
                })

                // //evento logout
                // $("#logout").click(function(){
                //     window.location.assign("./main.php?logout")
                // })
            })
        </script>

    </div>

</body>

</html>