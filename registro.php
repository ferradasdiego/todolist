<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <?php
	session_start();
	if(isset($_SESSION["user"]) && isset($_SESSION["id"])){
		header("location: ./main.php");
	}
	?>

    <title>Tareas</title>

</head>
<body>
    <h1 class="container">Tareas</h1>
    <div class="container">
        <h3>Registro</h3>
        <form action="./registro.php" method="post">
            <input name="user" type="text" placeholder="usuario">
            <input name="passwd" type="password" placeholder="contraseña">
            <button type="submit" class="btn btn-primary">Registrarse</button>
        </form>
        <p></p>
        <button><a href="./index.php">Loguearse</a></button>
        <?php

            require('./db.php');
                
                //consulta por busqueda
                if(isset($_POST["user"])&&isset($_POST["passwd"])){	
                    
                    $q = "SELECT * FROM `users` WHERE `user`='".$_POST["user"]."'";				
                    $r = mysqli_query($ms, $q);

                    if (!$r){
                        echo "<br>ERROR EN CONSULTA";
                    }else{
                        if ( mysqli_num_rows($r)>0 ){	

                            echo'<br>Lo sentimos :( <br>El usuario introducido ya está en uso.<br>Por favor, intentalo con otro nombre de usuario.';
                        }else{

                            $hashed_password = crypt($_POST["passwd"],"abc");//encripto la contraseña, el salt es abc(sin salt da error)

                            $q = "INSERT INTO `users` (`user`,`password`) VALUES ('".$_POST["user"]."','".$hashed_password."')";
                            $r = mysqli_query($ms, $q);

                            if ( !$r ){
                                echo "<br>ERROR EN CONSULTA!";
                            }else{
                                echo'<br>¡Registro completado satisfactoriamente!<br>Accede a Tareas.'; 
                            }
                        }
                    }

                }


                // password_hash(). Ejemplo de password_hash():
                // $pass = $_POST['password'];    
                // $passHash = password_hash($pass, PASSWORD_BCRYPT);
                // El algoritmo BCRYPT nos creará una cadena de 72 caracteres como máximo, la cual es distinta cada vez que se codifica, por lo que para comprobar que la contraseña introducida es la correcta debemos usar la función password_verify():
                // password_verify($pass, $passHash)
        ?>
    </div>
</body>
</html>