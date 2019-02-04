<?php
	

		// Configuración hora local
		date_default_timezone_set('Europe/Madrid');
		setlocale(LC_TIME, 'spanish');
		
		// Configuración de nuestro servidor y base de datos MySQL

		$host = "q7cxv1zwcdlw7699.chr7pe7iynqr.eu-west-1.rds.amazonaws.com";
		$user = "nsn4zf9336cdwk9t";
		$pass = "x0qw2s8u0ed81xqy";
		$db   = "sffhhad2bphoe6d5";

		//**********************//
		// columnas de la tabla://
		// id,user,password		//
		//**********************//

		// Intenta conectar con el servidor BD, usando los datos anteriores. Devuelve un objeto con la conexión, o un error si error.
		$ms = mysqli_connect($host, $user, $pass);
		if (!$ms){
			
			// si hubo error...
			die('ERROR: ' . mysqli_connect_errno());
			
		}else{
						
			// si no hubo error, lo que hay que hacer ahora es indicarle a qué BD concreta de mi servidor MySQL voy a querer hacer las consultas.
			// esto devuelve TRUE or FALSE (si no existe, o no tenemos permisos para conectarse con esa BD en concreto).
			if (mysqli_select_db($ms, $db)){
				
				//echo 'OK! BD seleccionada sin problemas.';
				
			}else{
				
				echo 'ERROR seleccionando BD!';
								
			}
		}	
		
?>