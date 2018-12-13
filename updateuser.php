<?php
session_start();
include('conexion/conexionBd.php');

if(isset($_POST['sent'])) {

	foreach($_POST as $calzon => $caca){		
			if($caca == "" && $calzon != "id") { $error[] = "La caja $calzon debe contener un valor"; }		
	}

if ($_FILES['uploadedfile']['name'] != "") {
    $target_path = "imagenes/";
$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 

$uploadedfileload=true;

$uploadedfile_size=$_FILES['uploadedfile']['size'];
$uploadedFileType = $_FILES['uploadedfile']['type'];


if ($uploadedfile_size>1000000){

$error[] = "El archivo es mayor que 1MB, debes reduzcirlo antes de subirlo<BR>";

$uploadedfileload=false;

}

if (!($uploadedFileType == "image/jpeg" OR $uploadedFileType =="image/gif")){
    $error[] =  " Tu archivo tiene que ser JPG o GIF. Otros archivos no son permitidos<BR>";
    
    $uploadedfileload=false;
}


$file_name=$_FILES["uploadedfile"]["name"];

$add="imagenes/$file_name";

if($uploadedfileload){

if(move_uploaded_file ($_FILES["uploadedfile"]["tmp_name"], $add)){
}

}

	if(!isset($error)) {
		$queryUserUpdate = sprintf("UPDATE usuario SET nombre = '%s', apellidos = '%s', foto = '%s'WHERE id =". $_SESSION['idUsuario'],
	  mysql_real_escape_string(trim($_POST["nombre"])),
      mysql_real_escape_string(trim($_POST["apellidos"])),
      mysql_real_escape_string(trim($file_name))
		);
	$resQueryUserUpdate = mysql_query($queryUserUpdate, $conexionBd) or die("No se pudo actualizar los datos... Revisa tu código plomo.");
    }
}else{
    if(!isset($error)) {
		$queryUserUpdate = sprintf("UPDATE usuario SET nombre = '%s', apellidos = '%s', foto = '%s'WHERE id =". $_SESSION['idUsuario'],
	  mysql_real_escape_string(trim($_POST["nombre"])),
      mysql_real_escape_string(trim($_POST["apellidos"])),
      mysql_real_escape_string(trim($_SESSION["userFoto"]))
		);
	$resQueryUserUpdate = mysql_query($queryUserUpdate, $conexionBd) or die("No se pudo actualizar los datos... Revisa tu código plomo.");
    }
}

    if ($resQueryUserUpdate) {
        $queryGetUser = sprintf("SELECT id, nombre, apellidos, correo, foto, plan FROM usuario WHERE id =". $_SESSION["idUsuario"]);

		$resQueryGetUser = mysql_query($queryGetUser, $conexionBd) or die("No se ejecutó el query en la base de datos");
		if(mysql_num_rows($resQueryGetUser)){
				$userData = mysql_fetch_assoc($resQueryGetUser);
                $_SESSION["nombre"] = $userData["nombre"];
                $_SESSION["apellidos"] = $userData["apellidos"];
                $_SESSION["idUsuario"] = $userData["id"];
                $_SESSION["userEmail"] = $userData["correo"];
                $_SESSION["userNombreCompleto"] = $userData["nombre"]. " ". $userData["apellidos"];
                $_SESSION["userFoto"] = $userData["foto"];
                $_SESSION["userPlan"] = $userData["plan"];
        }
        header("Location:music.php");
    }
    
}

if(isset($_GET["delete"])){
    $queryEliminarUsuario = "DELETE FROM usuario WHERE id=".$_SESSION["idUsuario"];
    $resQueryEliminarUsuario = mysql_query($queryEliminarUsuario, $conexionBd) or die ("No se ha podido eliminar el usuario");
    if ($resQueryEliminarUsuario) {
        header("Location:index.php");
    }
}
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/step.css">
    <link rel="stylesheet" href="css/update.css">
    <link rel="stylesheet" href="css/navbar.css">


    <title>Actualizar datos</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-nav">
    <a class="navbar-brand" href="#"><i class="fab fa-spotify fa-2x"></i></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img style="float:left" class="img" src= <?php echo'"imagenes/'.$_SESSION["userFoto"].'"'?> alt=""> 
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="music.php">Inicio</a>
          <a class="dropdown-item" href="adminadd.php">Opciones de administrador</a>
          <form value="Cerrar sesión" class="logout" action="music.php" method="post">
          <input type="submit" name="logout">
          </form>
        </div>
      </li>
    <div > </div>
    <p style="color:white; padding-top:16px;margin-left:10px;"> <?php echo $_SESSION["userNombreCompleto"]  ?></p>
      </ul>
      <ul class="nav navbar-nav navbar-center">
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2 input-field" type="search" placeholder="Buscar" aria-label="Search">
        </form>
      </ul>
    </div>
  </nav>
  <br>
    <div class="container">
         <div class="row">
                <div class="col-xl-12">
                    <h1>Actualiza tu perfil</h1>
                </div>
         </div>
         <br>
         <div class="row justify-content-center">
            <div class="col-xl-6">
                <span id = "span">
                    <img src= <?php echo'"imagenes/'.$_SESSION['userFoto'].'"'?> alt="" class = "circle">
                </span>
                        <form  action="updateuser.php" method="post" enctype = "multipart/form-data">   
                <div class="upload-btn-wrapper">       
                    <button style="margin-top:10px;margin-left:30px;" class="btn">Cambiar foto</button>
                    <input type="file" name="uploadedfile" id="files" value = "<?php echo $_SESSION['userFoto'];?>"/>              
                </div> 
            </div>              
                   
                        <div class="row justify-content-center">
                            <div class="col-xs-12">
                                <label for="">Nombre</label> <br>
                                    <input style="text-align:center;" value="<?php echo $_SESSION['nombre'];?>" type="text" name="nombre"> <br>
                                    <label for="">Apellidos</label> <br>
                                    <input style="text-align:center;" value="<?php echo $_SESSION['apellidos'];?>"type="text" name="apellidos"><br>                 
                                    <label for="">Correo</label> <br>
                                    <input  style="text-align:center;" disabled type="text" value="<?php echo $_SESSION['userEmail'];?>" type="text" name="apellidos""> 
                                        <div style="margin-left:22px; margin-top:15px;">   
                                        <input style="margin-top:15px;" type="submit" name="sent" value="Actualizar datos"> <br> <br>                                                                                                 
                            </div>              
                        </form>
                        <div class="row">
                        <div class="col">
                        <form action="updateuser.php" method="get"><input style="background:red;border:1px solid red" style="margin-top:15px;margin-left:10px;" type="submit" name="delete" value="Eliminar cuenta"></form>
                        </div>
                        </div>
            </div>
        </div>
        <br>
        <br>
        <div style="margin-top:4rem;" class="container-fluid">
        <div class="row justify-content-center">
                    <div class="col-xs-12">
                        <h2>¡Conoce las ventajas de unirte al premium!</h2>
                    </div>
                </div>
                <hr>
                <div class="row" style="text-align:center">
                    <div class="col-xs-4 box">
                        <p>Crea playlist ilimitadas: Con Gentlefy premium no tienes que preocuparte por tener un numero limitado de playlist. ¡Crea y sigue creando!</p>
                    </div>
                    <hr>
                    <div class="col-xs-4 box">
                        <p>Ten un numero ilimitado de canciones en tus playlist: Con Gentlefy premium no tienes porque preocuparte por que canciones vas a poner
                            en tu playlist, puedes poner de todo un poco sin preocuparte de llenarla.
                        </p>
                    </div>
                      <div class="col-xs-4 box">
                        <p>Siendo premium, puedes personalizar tus datos una vez creada tus cuentas. ¡Cuantas veces quieras!</p>
                    </div>
                </div>
                    <div class="row justify-content-center">
                        <div class="col-xs-12">
                            <input type="submit" value="¡Probar premium gratis!">
                            <br>
                        </div>
                    </div>
        </div>

<script src="js/index.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>