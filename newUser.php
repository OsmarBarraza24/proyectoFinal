<?php 
session_start();
include('conexion/conexionBd.php');

if(isset($_POST['sent'])) {

	// Validamos si no hay cajas vacias
	foreach($_POST as $calzon => $caca){		
			if($caca == "") { $error[] = "La caja $calzon debe contener un valor"; }		
	}

	// Validamos que los password coincidan
	if($_POST["password"] != $_POST["password2"]) {
		$error[] = "Los password no coinciden.";
	}

	// Validamos si el correo proporcionado está siendo utilizado

	//Definimos el query para evaluar el correo contra la BD
	$queryCheckEmail = sprintf("SELECT id FROM usuario WHERE correo = '%s'",
			mysql_real_escape_string(trim($_POST["email"]))
	);

	// Ejecutamos el query
	$resQueryCheckEmail = mysql_query($queryCheckEmail, $conexionBd) or die("El query para verificar el email falló");

	// Contamos los resultados para determinar si el correo existe o no
	if(mysql_num_rows($resQueryCheckEmail)) {
		$error[] = "El email proporcionado ya está siendo utilizado";
	}

	// Si estamos libres de errores procedemos a la inserción de los datos en la BD
	if(!isset($error)) {
		// Definimos la consulta que se va a ejecutar para guardar los datos del usuario
		$queryUserRegister = sprintf("INSERT INTO usuario (correo, contrasenia) VALUES ('%s', '%s')",
			mysql_real_escape_string(trim($_POST["email"])),
			mysql_real_escape_string(trim($_POST["password"]))
		);
		$resQueryUserRegister = mysql_query($queryUserRegister, $conexionBd) or die("No se pudo guardar el usuario en la BD... Revisa tu código plomo.");

		


		// Si los datos fueron guardados con exito hacemos una redirección
		if($resQueryUserRegister) {
			$queryGetUser = sprintf("SELECT (id) FROM usuario WHERE correo = '%s' AND contrasenia = '%s'",
				mysql_real_escape_string(trim($_POST["email"])),
				mysql_real_escape_string(trim($_POST["password"]))
			);

			$resQueryGetUser = mysql_query($queryGetUser, $conexionBd) or die("No se ejecutó el query en la base de datos");
			if(mysql_num_rows($resQueryGetUser)){
				$userData = mysql_fetch_assoc($resQueryGetUser);
				$_SESSION['idUsuario'] = $userData['id'];
			}
			header("Location:step.php");
		} 

	}


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/index.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <title>Nuevo usuario</title>
</head>
<body  data-vide-bg="img/video">
    <form action="newUser.php" method="post">
    <div class="login-container">
        <h1>Registra tus datos</h1>
		<?php 
		if(isset($error)){
			foreach($error as $value){
				echo "<h4 style='color:red;text-align:center'> $value </h4>";
			}
		}
		?>
    <label style="color:white;" for="correo">Correo electrónico</label> <br>
        <div class="input">
            <input  type="text" name="email" id=""> <br>
        </div>           
        <label style="color:white;" for="password">Contraseña</label> <br>
        <div class="input">
            <input type="password" name="password" id=""> <br>
        </div>
        <label style="color:white;" for="">Confirmación de contraseña</label>
        <div class="input">
            <input type="password" name="password2">
        </div>
          <input value="C R E A R  U S U A R I O" type="submit" name="sent">
            
    </div>   
    </form>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="js/jquery.vide.js"></script>
</body>
</html>