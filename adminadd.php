<?php
session_start();
include("conexion/conexionBd.php");
if(isset($_GET['enviarA'])){
  if($_GET["nombreA"] == ""){
    $error[] = "No se llenó el campo requerido";
  }

  if(!isset($error)){
    $queryAgregarArtista = sprintf("INSERT INTO artista (nombre) VALUE ('%s')",
      mysql_real_escape_string(trim($_GET["nombreA"]))
    );

    $resQueryAgregarArtista = mysql_query($queryAgregarArtista, $conexionBd) or die ("No se pudo agregar artista a la base de datos");
    
    if($resQueryAgregarArtista){
      header("Location:adminadd.php");
      $mensaje = "Se ha agregado el artista con éxito";
    }
  }
}

if(isset($_POST["subirAl"])){
  foreach($_POST as $calzon => $caca){		
    if($caca == "" && $calzon != "enviarAl")  $error[] = "El campo $calzon debe contener un valor"; 		
  }

  $target_path = "imagenes/";
  $target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 

  $uploadedfileload=true;

  if($_FILES["uploadedfile"]["name"] != ""){
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
  }else $error[] = "Es necesario subir una imagen";

  if(!isset($error)){
    $querySubirAlbum = sprintf("INSERT INTO album (nombre, genero, idArtista, imagen) VALUES ('%s', '%s', %d , '%s')",
      mysql_real_escape_string(trim($_POST["nombreAl"])),
      mysql_real_escape_string(trim($_POST["generoAl"])),
      mysql_real_escape_string(trim($_POST["nombreAr"])),
      $file_name
    );

    $resQuerySubirAlbum = mysql_query($querySubirAlbum, $conexionBd) or die ("No se puedo agregar album");
    
    if($resQuerySubirAlbum){
      header("Location:adminadd.php");
      $mensaje = "Se ha subido el album con exito";
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
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/music.css">
    <link rel="stylesheet" href="css/step.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Opciones de administrador</title>
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
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <form action="music.php" method="post">
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
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xs-12">
            <h2>Opciones de administrador</h2>
        </div>
    </div>
</div>
</div>

<div class="container">
  <div style="width:100%" class="accordion" id="accordionExample">
  <div style="width:100%; class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseTwo">
          Agregar nuevo artista
        </button>
      </h5>
    </div>
    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <div class="containter">
          <div class="row justify-content-center">
            <div class="col-xs-12">
                <h5>Agregar artista</h5>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-xs-12">
          </div>        
        </div>
            <div class="row justify-content-center">
              <div class="col-xs-12">
                <form enctype = "multipart/form-data" method="get" action="adminadd.php">
                  <label for="nombreA">Nombre</label> <br>
                  <input type="text" name="nombreA"> <br>
                  <input class="btn btn-primary" style="margin-left:18px;margin-top:10px;" type="submit" value="Agregar" name="enviarA"> 
                </form>
              </div>
            </div>
      </div>
    </div>
  </div>
  <div style="width:100%; class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Agregar nuevo album
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
        <div class="container">
          <div class="row">
            <div class="col">           
               <span style="margin-left:10px;" id="span"> <img  class="album" src="imagenes/Osmar.jpg" alt=""> <br></span>
               <div class="upload-btn-wrapper">
                    <form action="adminadd.php" method="get" enctype = "multipart/form-data">
                      <button style="margin-top:10px" class="btn">Subir foto</button>
                      <input  type="file" name="uploadedfile" id="files"/>
                </div>
             </div>
             </div>
          <div class="row">
            <div class="col">
          <label for="nombreAl">Nombre del album</label> <br>
          <input type="text" name="nombreAl"> <br>
          <label for="generoAl">Genero</label> <br>
          <input type="text" name="generoAl" > <br>
          <label for="artista">Artista</label>
          <div class="col-xs-12 justify-self-end">
          <select style="margin-top:5px;width:280px;border-radius: 20px;" class="dropdown-toggle" name="nombreAr" id="">
              <?php 
              $queryObtenerArtistaForm = "SELECT * FROM artista";
              $resQueryObtenerArtistaForm = mysql_query($queryObtenerArtistaForm, $conexionBd) or die ("No se realizó la consulta en el form");
              
              while($artisData = mysql_fetch_assoc($resQueryObtenerArtistaForm)){
              ?>
              <option value= <?php echo '"'.$artisData["id"].'"'?>><?php echo $artisData["nombre"]?></option>
              <?php }?>
          </select> <br>
          </div>
          
          <input style="margin-top:25px;margin-left:15px;" type="submit" name="subirAl">
          </form>
            </div>
          </div>            
        </div>
      </div>
    </div>
  </div>
  <div style="width:100%; class="card">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Agregar canciones.
        </button>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
</div>
</div>
<script src="js/adminimg.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>