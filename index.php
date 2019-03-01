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
if (isset($_SESSION["user"]) && isset($_SESSION["id"])) {
    header("location: ./main.php");
}
?>
    <title>Document</title>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">

            <h4 class="card-title text-center">Login</h4>
            <form class="form-signin" action="./index.php" method="post">
              <div class="form-label-group">
                <input type="text" id="inputEmail" name="user" class="form-control" placeholder="Nombre de usuario" required autofocus>
                <label for="inputEmail">Nombre de usuario</label>
              </div>

              <div class="form-label-group">
                <input type="password" id="inputPassword" name="passwd" class="form-control" placeholder="Contraseña" required>
                <label for="inputPassword">Contraseña</label>
              </div>

              <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">ENTRAR</button>
            </form>
            <hr class="my-4">
            <a href="./registro.php" class="btn btn-lg btn-facebook btn-block text-uppercase">REGISTRARSE</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php

require './db.php';

if (isset($_POST["user"]) && isset($_POST["passwd"])) {

  if ($_POST["user"] != "" && $_POST["passwd"] != "") {

    $q = "SELECT * FROM `users` WHERE `user` = '" . $_POST["user"] . "'";
    $r = mysqli_query($ms, $q);

    if (!$r) {
      echo "<br>ERROR EN CONSULTA: ";
    } else {
      if (mysqli_num_rows($r) < 1) {
        echo '<script>alert("ERROR: Email o contraseña no son correctos. Por favor, prueba otra vez.")</script>';
      } else {

        $devolucion = mysqli_fetch_assoc($r); //lo transforma en un array

        if (hash_equals($devolucion["password"], crypt($_POST["passwd"], $devolucion["password"]))) { //si el hash de la nueva es igual al has guardado de la vieja
          print_r("Te has logueado " . $devolucion["user"] . "");
          $_SESSION["user"] = $devolucion["user"];
          $_SESSION["id"] = $devolucion["id"];
          header("location: ./index.php");
        } else {
          echo "<br>Ups....<br>Has introducido mal el nombre de usuario o la contraseña";
        }
      }
    }
  }
}

?>
</body>
</html>
