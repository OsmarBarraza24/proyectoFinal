<?php 
session_start();
include('conexion/conexionBd.php');



if(isset($_POST['sent'])) {

	foreach($_POST as $calzon => $caca){		
			if($caca == "") { $error[] = "La caja $calzon debe contener un valor"; }		
	}

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
  $error[] = " Tu archivo tiene que ser JPG o GIF. Otros archivos no son permitidos<BR>";
    
    $uploadedfileload=false;
}


$file_name="imagenes/$file_name";

$add="imagenes/$file_name";

if($uploadedfileload){

if(move_uploaded_file ($_FILES["uploadedfile"]["tmp_name"], $add)){
    echo " Ha sido subido satisfactoriamente";
}

}

	if(!isset($error)) {
		$queryUserUpdate = sprintf("UPDATE usuario SET nombre = '%s', apellidos = '%s' foto = '%s' genero = '%s'WHERE id = '%d'",
			mysql_real_escape_string(trim($_POST["nombre"])),
      mysql_real_escape_string(trim($_POST["apellidos"])),
      mysql_real_escape_string(trim($file_name)),
      mysql_real_escape_string(trim($_POST["genero"])),
      mysql_real_escape_string(trim($_POST["id"]))
		);

		$resQueryUserUpdate = mysql_query($queryUserUpdate, $conexionBd) or die("No se pudo actualizar los datos... Revisa tu código plomo.");

   
		if($resQueryUserUpdate) {
			header("Location:music.php");
		} 

	}

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Spatifai</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
    crossorigin="anonymous">
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/step.css">
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
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-center">
        <form class="form-inline my-2 my-lg-0">

          <input class="form-control mr-sm-2 input-field" type="search" placeholder="Buscar" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0 input-button" type="submit"><i class="fas fa-search"></i>
            Buscar</button>
        </form>
      </ul>

    </div>
  </nav>
  <div class="container">
    <div class="row">
      <div class="col">
        <h2 style="margin-top: 50px;">Una cosa más...</h2>
      </div>
    </div>
    <div class="container">
      <div class="row ">
        <div class="col">
          <p>Antes de empezar a escuchar la música que más te gusta necesitamos un poco más de información sobre ti.</p>
        </div>
      </div>
      <br>
      <br>
    </div>
    <div class="row justify-content-center">
      <div class="col-12-xs">
      <span id = "span">
        <img src="img/user.png" alt="" class = "circle">
      </span>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12-xs">
        <br>
        <div class="upload-btn-wrapper">
              <form action="step.php" method="post">
                <button class="btn">Subir foto</button>
                <input type="file" name="uploadedfile" id="files"/>
        </div>
      </div>
    </div>
    <br>
    <div class="row justify-content-center">
      <div class="col-12-xs">
        <h2>Datos personales</h2>
      </div>
    </div>
    <?php 
        if(isset($error)){
          echo "<h5 style='text-align:center;color:red'> <i> Favor de llenar todos los campos... </i></h5>";
        }
      ?>
    <div class="row justify-content-center">
      <div class="col-12-xs">
          <label for="nombre">Nombre</label> <br>
          <input type="text" name="nombre"> <br>
          <label for="apellido">Apellidos</label> <br>
          <input type="text" name="apellidos"> <br>
          <label for="genero">Genero</label> <br>
          <div class="selector">
          <select name="genero">
           <option name="HOMBRE" value="0">Hombre</option>
            <option name="MUJER" value="1">Mujer</option>
             <option name="NA" value="2">Prefiero no especificar</option>
         </select>
          </div>        
          <div class="container"><br>
            <div class="row justify-content-center">
               <div class="col-12-xs">
                 <input type="submit" value="Confirmar" name="sent">
                 <input type="hidden" name="id" value="<?php $_SESSION["userId"];?>">
        </form>
      </div>
    </div>
  </div>
  <br>
      </div>
    </div>
  </div>
  <br>

  <div class="footer">
    <p>Proyecto de aplicaciones web</p>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
    crossorigin="anonymous"></script>
  <script src="js/index.js"></script>
</body>

</html>