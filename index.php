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
        <h3>Login</h3>
        <form action="./index.php" method="post">
            <input name="user" type="text" placeholder="usuario">
            <input name="passwd" type="password" placeholder="contraseña">
            <button type="submit" class="btn btn-primary">Log In</button>
        </form>
        <p></p>
        <button><a href="./registro.php">Registrarse</a></button>
        <?php
            // if(isset($_POST["user"])&&isset($_POST["passwd"])){
            //     echo $_POST["user"];
            //     echo "<p>";
            //     echo $_POST["passwd"];   
            // }
            //************************************************************************************************************** */

            require('./db.php');
                
            if(isset($_POST["user"])&&isset($_POST["passwd"])){

                if($_POST["user"] != "" && $_POST["passwd"] != ""){


                    $q = "SELECT * FROM `users` WHERE `user` = '".$_POST["user"]."'";				
                    $r = mysqli_query($ms, $q);

                    if (!$r){
                        echo "<br>ERROR EN CONSULTA: ";
                    }else{
                        if ( mysqli_num_rows($r)<1 ){	
                            echo'ERROR: Email o contraseña no son correctos<br>Por favor, prueba otra vez.';
                        }else{                       

                            $devolucion=mysqli_fetch_assoc($r);	//lo transforma en un array
 
                            if (hash_equals($devolucion["password"], crypt($_POST["passwd"], $devolucion["password"]))) {
                                print_r("Te has logueado ".$devolucion["user"]."");
                                $_SESSION["user"]=$devolucion["user"];
                                $_SESSION["id"]=$devolucion["id"];
                                header("location: ./index.php");
                            }else{
                                echo"<br>Ups....<br>Has introducido mal el nombre de usuario o la contraseña";
                            }
                        }
                    }
                }
            }
                
        ?>
    </div>
</body>
</html>