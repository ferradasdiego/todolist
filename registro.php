<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">

    <?php
      session_start();
      if(isset($_SESSION["user"]) && isset($_SESSION["id"])){
        header("location: ./main.php");
      }
	  ?>
    <title>Registro</title>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <h4 class="card-title text-center">Registro</h4>
            <form class="form-signin" action="./registro.php" method="post">
              <div class="form-label-group">
                <input type="text" id="inputEmail" name="user" class="form-control" placeholder="Nombre de usuario" required autofocus>
                <label for="inputEmail">Nombre de usuario</label>
              </div>

              <div class="form-label-group">
                <input type="password" id="inputPassword" name="passwd" class="form-control" placeholder="Contraseña" required>
                <label for="inputPassword">Contraseña</label>
              </div>

              <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Registrarse</button>
            </form>
            <hr class="my-4">
            <a href="./index.php" class="btn btn-lg btn-facebook btn-block text-uppercase">login</a>
          </div>
        </div>
      </div>
    </div>
  </div>

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

          $hashed_password = crypt($_POST["passwd"],"aB1(.");//encripto la contraseña, el salt es abc(sin salt da error)

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
  ?>
</body>
</html>