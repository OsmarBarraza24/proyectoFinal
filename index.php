<?php 
session_start();
include('conexion/conexionBd.php');
$pattern = '^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$';
if(isset($_POST["sent"])) {
	// Validamos los campos vacios
	foreach ($_POST as $calzon => $caca) {
		if($caca == "") $error[] = "El campo $calzon es obligatorio";
	}

	// Si no hay errores, definimos el query a ejecutar
	if(!isset($error)) {
		// Definimos el query consultar en la BD el email y password del usuario
		$queryLoginUser = sprintf("SELECT id,email FROM tblUsuarios WHERE email = '%s' AND password = '%s'",
			mysql_real_escape_string(trim($_POST["email"])),
			mysql_real_escape_string(trim($_POST["password"]))
		);

		// Ejecutamos el query
		$resQueryLoginUser = mysql_query($queryLoginUser, $conexionBd) or die("No se pudo ejecutar el query para login de usuario");

		// Contamos los resultados, si no hay, definimos un error
		if(mysql_num_rows($resQueryLoginUser)) {
			$userData = mysql_fetch_assoc($resQueryLoginUser);
			$_SESSION["userId"] = $userData["id"];
			$_SESSION["userEmail"] = $userData["email"];
			header("Location: music.php");
		}
		else {
			$errorLog[] = "si";
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
    <title>Spatifai</title>
    <link rel="stylesheet" href="css/index.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>
<body data-vide-bg="img/video">
    <form action="index.php" method="post">
        <div class="login-container">
            <h1>INICIO DE SESIÓN</h1>
                <?php 
                if(isset($error)){
                    echo "<h4 style='color:red;text-align:center'> <i> *Favor de llenar los campos que se solicitan* </i> </h4>";
                }
                if(isset($errorLog)){
                    echo "<h4 style='color:red;text-align:center'><i> El correo o la contraseña no son válidos, favor de 
                    verificar sus datos</i></h1>";
                }
                ?>
                <label style="color:white;" for="email">Usuario</label> <br>
                    <div class="input">
                        <input style="color:white;" name="email" type="text"> <br>
                    </div>   
                <label style="color:white;" for="password">Contraseña</label> <br>
                    <div class="input">                    
                        <input name="password" type="password"> <br>
                    </div>            
                         <input value="I N I C I A R    S E S I O N" type="submit" name="sent"> <br>
                             <div class="forgot">
                                <a href="newUser.php">Crear nueva cuenta</a> <br> <br> 
                                    <a href="#">¿Olvidaste tu contraseña?</a>
                             </div>                
        </div>    
    </form>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="js/jquery.vide.js"></script>
</body>
</html>