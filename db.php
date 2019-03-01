<?php

// Configuración hora local
date_default_timezone_set('Europe/Madrid');
setlocale(LC_TIME, 'spanish');

// Configuración de nuestro servidor y base de datos MySQL
$url = getenv('JAWSDB_URL');
$dbparts = parse_url($url);

$hostname = $dbparts['host'];
$username = $dbparts['user'];
$password = $dbparts['pass'];
$database = ltrim($dbparts['path'],'/');

//**********************//
// columnas de la tabla://
// id,user,password        //
//**********************//

// Intenta conectar con el servidor BD, usando los datos anteriores. Devuelve un objeto con la conexión, o un error si error.
$ms = mysqli_connect($hostname, $username, $password);
if (!$ms) {

    // si hubo error...
    die('ERROR: ' . mysqli_connect_errno());

} else {

    // si no hubo error, lo que hay que hacer ahora es indicarle a qué BD concreta de mi servidor MySQL voy a querer hacer las consultas.
    // esto devuelve TRUE or FALSE (si no existe, o no tenemos permisos para conectarse con esa BD en concreto).
    if (mysqli_select_db($ms, $database)) {

        //echo 'OK! BD seleccionada sin problemas.';

    } else {

        echo 'ERROR seleccionando BD!';

    }
}
