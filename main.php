<?php
session_start();
require('./db.php');

if(!isset($_SESSION["user"]) && !isset($_SESSION["id"])){
    header("location: ./index.php");
}
//Saludo
    if(isset($_SESSION["user"]) && isset($_SESSION["id"])){
        $usuario=$_SESSION["user"];
    }
//Cerrar Sesión
    if(isset($_GET["logout"])){
        session_start();
        session_destroy();
        unset($_SESSION['user']);
        unset($_SESSION['id']);
        header("location:./index.php");
    }
    
    if(isset($_GET["borrar"])){
        $q = "DELETE FROM `chores` WHERE `id_tarea` = '".$_GET["borrar"]."'";
        $r = mysqli_query($ms, $q);
        if ( !$r ){
            echo "<br>ERROR EN LA INSERCION";
        }else{
            header("location: ./main.php");
        }
    }

    if(isset($_GET["completar"])){
        // UPDATE MyGuests SET lastname='Doe' WHERE id=2
        $q = "UPDATE `chores` SET clase= 'completada' WHERE `id_tarea` = '".$_GET["completar"]."'";
        $r = mysqli_query($ms, $q);
        if ( !$r ){
            echo "<br>ERROR EN LA INSERCION";
        }else{
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
    <title>Tareas</title>
</head>
<body>
    <div id="cabecera">
       <h1>Main</h1> 
       <div><h3>Bienvenido <?php echo $usuario;?></h3></div>
        <div>
            <button class="btn btn-warning" id="logout">Cerrar Sesión</button>
        </div>
    </div>

    <div id="introducir">
        <form action="./main.php" method="post" id="formulario">
            <input type="text" name="titulo" placeholder="Introduce el titulo de tu tarea" style="width:60%; border:1px solid black">
            <!-- <input id="campo" type="text" name="cuerpo" placeholder="Introduce tu tarea"> -->
            <button type="submit" class="btn btn-primary">Publicar Tarea</button>
        </form>
        <textarea rows="4" cols="50" name="cuerpo" id="campo" form="formulario" style="width:60%; padding:0px; border:1px solid black">Introduce el cuerpo de tu tarea.</textarea>

    </div>

    <div id="herramientas">
        <button id="tachar">Completar Tarea</button>
        <button id="borrar">Borrar Tarea</button>      
    </div>

    <div id="tareas">
        
        <?php
        //Cargar las tareas al entrar en la página
            

            $q = "SELECT * FROM `chores` WHERE `id_user` = '".$_SESSION["id"]."'";				
            $r = mysqli_query($ms, $q);
            if (!$r){
                echo "<br>ERROR EN CONSULTA: ";
            }else{
                if ( mysqli_num_rows($r)<1 ){
                    echo"Aún no hay tareas";
                }else{                       

                    while($resultado=mysqli_fetch_assoc($r)){   //mientras hay tareas por mostrar 

                        if($resultado['clase']!="completada"){
                            echo "<div class='tarea' id='".$resultado['id_tarea']."'>";
                            echo "<u class='".$resultado['clase']."'>".$resultado["titulo"]."</u>: ";
                            echo "<br>";
                            echo "<p class='".$resultado['clase']."'>".$resultado['cuerpo']."</p>";
                            echo "<button href='./main.php?completar=".$resultado['id_tarea']."' class='completar btn btn-success' id='".$resultado['id_tarea']."'>Completar Tarea</button><button type='button' class='borrar btn btn-danger' href='./main.php?borrar=".$resultado['id_tarea']."' id='".$resultado['id_tarea']."'>Borrar Tarea</button></div><hr>";
                        }else{
                            echo "<div class='tarea' id='".$resultado['id_tarea']."'>";
                            echo "<u class='".$resultado['clase']."'>".$resultado["titulo"]."</u>: ";
                            echo "<br>";
                            echo "<p class='".$resultado['clase']."'>".$resultado['cuerpo']."</p>";
                            echo "<button type='button' class='borrar btn btn-danger' id='".$resultado['id_tarea']."'>Borrar Tarea</button></div><hr>";
                        }
                    }
                }
            }

        //************************************

        //Introducir una nota en la bd
        if(isset($_POST["titulo"])&&isset($_POST["cuerpo"])){
            if($_POST["titulo"]!=""){
                $q = "INSERT INTO `chores` (`id_user`,`titulo`,`cuerpo`) VALUES ('".$_SESSION["id"]."','".$_POST["titulo"]."','".$_POST["cuerpo"]."')";
            }else{
                $q = "INSERT INTO `chores` (`id_user`,`titulo`,`cuerpo`) VALUES ('".$_SESSION["id"]."','Titulo por defecto','".$_POST["cuerpo"]."')";
            }
            
            $r = mysqli_query($ms, $q);
            if ( !$r ){
                echo "<br>ERROR EN LA INSERCION";
            }else{
                header("location: ./main.php");
            }
        }
        //*****************************


      
        ?>
        <script>
            $(document).ready(function(){
                $(".borrar").click(function(){
                    var id=$(this).attr("id")
                    window.location.assign("./main.php?borrar="+id)
                })

                $(".completar").click(function(){
                    var id=$(this).attr("id")
                    window.location.assign("./main.php?completar="+id)
                })

                $("#logout").click(function(){
                    window.location.assign("./main.php?logout")
                })
            })
        </script>

    </div>

</body>

</html>