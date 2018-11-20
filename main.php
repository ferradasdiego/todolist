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
    <?php
    session_start();

    if(!isset($_SESSION["user"]) && !isset($_SESSION["id"])){
        header("location: ./index.php");
    }
	?>
    <title>Tareas</title>
</head>
<body>
    <div id="cabecera">
       <h1>Main</h1> 
        <?php

        //Saludo
            if(isset($_SESSION["user"]) && isset($_SESSION["id"])){
                echo "<div><h3>Bienvenido ".$_SESSION["user"]."</h3></div>";
            }
        //Cerrar Sesión
            if(isset($_GET["logout"])){
				session_start();
				session_destroy();
				unset($_SESSION['user']);
				unset($_SESSION['id']);
				header("location:./index.php");
            }
            
        ?>
        <div>
            <button><a href="./main.php?logout">Cerrar Sesión</a> </button>
        </div>
    </div>

    <div id="introducir">
        <form action="./main.php" method="post">
            <input type="text" name="titulo" placeholder="Introduce el titulo de tu tarea">
            <input id="campo" type="text" name="cuerpo" placeholder="Introduce tu tarea">
            <input type="submit">
        </form>
            <!-- <textarea name="" id="" cols="30" rows="10"></textarea> -->
    </div>

    <div id="herramientas">
        <button id="tachar">Completar Tarea</button>
        <button id="borrar">Borrar Tarea</button>      
    </div>

    <div id="tareas">
        
        <?php
        //Cargar las tareas al entrar en la página
            require('./db.php');

            $q = "SELECT * FROM `chores` WHERE `id_user` = '".$_SESSION["id"]."'";				
            $r = mysqli_query($ms, $q);
            if (!$r){
                echo "<br>ERROR EN CONSULTA: ";
            }else{
                if ( mysqli_num_rows($r)<1 ){
                    echo"Aún no hay tareas";
                }else{                       

                    while($resultado=mysqli_fetch_assoc($r)){   //mientras hay usuarios por mostrar 
                        echo "<div class='tarea' id='".$resultado['id_tarea']."'>";
                        echo "<u>".$resultado["titulo"]."</u>: ";
                        echo "<br>";
                        echo $resultado["cuerpo"];
                        echo "<input type='checkbox' name='checkbox'></div><hr>";
                    }
                }
            }
        //************************************

        //Introducir una nota en la bd
        if(isset($_POST["titulo"])&&isset($_POST["cuerpo"])){
            $q = "INSERT INTO `chores` (`id_user`,`titulo`,`cuerpo`) VALUES ('".$_SESSION["id"]."','".$_POST["titulo"]."','".$_POST["cuerpo"]."')";
            $r = mysqli_query($ms, $q);
            if ( !$r ){
                echo "<br>ERROR EN LA INSERCION";
            }else{
                header("location: ./main.php");
            }
        }
        //*****************************
        ?>
        <!-- Borrar nota -->
        <script>
            $("#borrar").click(function(){
                // borro todas las tareas en las que su checkbox esté marcada
            })
        </script>
        
    </div>
    
</body>
</html>